<?php

namespace App\Jobs;

use App\Cache\ContentCache;
use App\Jobs\Concerns\DisablesMissingRecords;
use App\Models\TicketSubscription;
use App\Services\SpektrixApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Imports the ticket subscription structures (flex passes) that can be bought
 * online, along with their pricing sets and web-channel sale windows.
 *
 * Reads through webGet() rather than get() for the same reason as
 * FetchCustomerTagData: web mode returns only what Spektrix has published to the
 * web channel, which is exactly the set that should be sellable on the site. An
 * authenticated read would also hand back structures that exist only for the box
 * office.
 *
 * Everything displayed beyond name and price — image, description, benefits,
 * terms — is editor-supplied, because the API carries none of it. Not even the
 * number of tickets in a pass: that lives in the structure name alone.
 */
class FetchTicketSubscriptionData implements ShouldQueue
{
    use Dispatchable, DisablesMissingRecords, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(SpektrixApi $spektrix)
    {
        $response = $spektrix->webGet('ticket-subscription-structures');

        // Bail rather than disabling everything if Spektrix is unreachable — a
        // failed fetch must not pull every subscription off the site.
        if (! $response->successful()) {
            Log::error('FetchTicketSubscriptionData: aborted, Spektrix read failed', [
                'status' => $response->status(),
            ]);

            return;
        }

        ContentCache::defer(function () use ($response) {
            $this->sync($response->json() ?? []);
        });
    }

    protected function sync(array $structures): void
    {
        $seen = [];

        foreach ($structures as $structure) {
            $name = $structure['name'] ?? null;

            if (! $name) {
                continue;
            }

            // The structure has no id of its own, so the name is the natural key.
            $id = Str::slug($name);
            $seen[] = $id;

            TicketSubscription::withoutGlobalScopes()->updateOrCreate(
                ['id' => $id],
                [
                    'enabled' => true,
                    'name' => $name,
                    'spektrix_description' => $structure['description'] ?: null,
                    'pricing_sets' => $this->pricingSets($structure),
                    // The Utc variants are the ones to trust; the unsuffixed
                    // fields are in the client's local time.
                    'on_sale_at' => $structure['onSaleWebChannelUtc'] ?? null,
                    'off_sale_at' => $structure['offSaleWebChannelUtc'] ?? null,
                ]
            );
        }

        $this->disableMissing(TicketSubscription::class, $seen);
    }

    /**
     * Keep only the fields the front end needs. The pricing set id is what gets
     * posted to the basket, so it is the one part that must survive intact.
     */
    protected function pricingSets(array $structure): array
    {
        return array_values(
            array_map(fn ($set) => [
                'id' => $set['id'],
                'name' => $set['name'] ?? '',
                'price' => (float) ($set['price'] ?? 0),
            ], $structure['pricingSets'] ?? [])
        );
    }
}
