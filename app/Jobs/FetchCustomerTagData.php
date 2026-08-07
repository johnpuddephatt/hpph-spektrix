<?php

namespace App\Jobs;

use App\Cache\ContentCache;
use App\Jobs\Concerns\DisablesMissingRecords;
use App\Models\SpektrixStatement;
use App\Models\SpektrixTag;
use App\Models\SpektrixTagGroup;
use App\Services\SpektrixApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Imports the customer tag groups, tags and contact statements that a signup form
 * may offer.
 *
 * Deliberately reads through webGet() rather than get(). An authenticated (Owner
 * mode) read returns every tag group, including Spektrix's automatic ones — RFV,
 * Dotdigital sync and similar — which are recalculated on a schedule. Offering one
 * of those on a form would appear to work and then be silently undone at the next
 * Spektrix refresh. Automatic tags cannot be marked web-visible, so the web-mode
 * response is exactly the set that is safe to set by hand.
 */
class FetchCustomerTagData implements ShouldQueue
{
    use Dispatchable, DisablesMissingRecords, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(SpektrixApi $spektrix)
    {
        $groups = $spektrix->webGet('tag-groups');
        $statements = $spektrix->webGet('statements');

        // Bail rather than disabling everything if Spektrix is unreachable — a
        // failed fetch must not empty every signup form on the site.
        if (! $groups->successful() || ! $statements->successful()) {
            Log::error('FetchCustomerTagData: aborted, Spektrix read failed', [
                'tag_groups_status' => $groups->status(),
                'statements_status' => $statements->status(),
            ]);

            return;
        }

        ContentCache::defer(function () use ($groups, $statements) {
            $this->syncTagGroups($groups->json() ?? []);
            $this->syncStatements($statements->json() ?? []);
        });
    }

    protected function syncTagGroups(array $groups): void
    {
        $seenGroups = [];
        $seenTags = [];

        foreach ($groups as $group) {
            $seenGroups[] = $group['id'];

            SpektrixTagGroup::withoutGlobalScopes()->updateOrCreate(
                ['id' => $group['id']],
                [
                    'enabled' => true,
                    'name' => $group['name'] ?? '',
                    'description' => $group['description'] ?? null,
                ]
            );

            foreach ($group['tags'] ?? [] as $tag) {
                $seenTags[] = $tag['id'];

                SpektrixTag::withoutGlobalScopes()->updateOrCreate(
                    ['id' => $tag['id']],
                    [
                        'enabled' => true,
                        'name' => $tag['name'] ?? '',
                        'spektrix_tag_group_id' => $group['id'],
                    ]
                );
            }
        }

        $this->disableMissing(SpektrixTagGroup::class, $seenGroups);
        $this->disableMissing(SpektrixTag::class, $seenTags);
    }

    protected function syncStatements(array $statements): void
    {
        $seen = [];

        foreach ($statements as $statement) {
            $seen[] = $statement['id'];

            SpektrixStatement::withoutGlobalScopes()->updateOrCreate(
                ['id' => $statement['id']],
                [
                    'enabled' => true,
                    'text' => $statement['text'] ?? '',
                ]
            );
        }

        $this->disableMissing(SpektrixStatement::class, $seen);
    }

}
