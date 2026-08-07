<?php

namespace App\Jobs;

use App\Cache\ContentCache;
use App\Jobs\Concerns\DisablesMissingRecords;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class FetchFundData implements ShouldQueue
{
    use Dispatchable, DisablesMissingRecords, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();
        $res = $client->request(
            "GET",
            "https://system.spektrix.com/" .
                nova_get_setting("spektrix_client_name") .
                "/api/v3/funds"
        );

        $funds = json_decode($res->getBody()->__toString());

        ContentCache::defer(function () use ($funds) {
            foreach ($funds as $fund) {
                \App\Models\Fund::withoutGlobalScopes()->updateOrCreate(
                    ["id" => $fund->id],
                    [
                        "enabled" => true,
                        "name" => $fund->name ?? null,
                        "description" => $fund->description ?? null,
                        "code" => $fund->code ?? false,
                        // "default_donation_amount" =>
                        //     $fund->defaultDonationAmount ?? null,
                    ]
                );
            }

            $this->disableMissing(
                \App\Models\Fund::class,
                array_column((array) $funds, "id")
            );
        });
    }
}
