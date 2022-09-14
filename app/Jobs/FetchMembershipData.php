<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class FetchMembershipData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
                "/api/v3/memberships"
        );

        $memberships = json_decode($res->getBody()->__toString());

        \App\Models\Membership::query()->update(["enabled" => false]);

        foreach ($memberships as $membership) {
            \App\Models\Membership::withoutGlobalScopes()->updateOrCreate(
                ["id" => $membership->id],
                [
                    "enabled" => true,
                    "name" => $membership->name ?? null,
                    "description" => $membership->description ?? null,
                    "long_description" => $membership->htmlDescription ?? false,
                    "price" => $membership->price ?? null,
                    "renewal_price" => $membership->renewal_price ?? null,
                ]
            );
        }
    }
}
