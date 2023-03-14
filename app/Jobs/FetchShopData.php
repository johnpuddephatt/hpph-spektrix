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

class FetchShopData implements ShouldQueue
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
                "/api/v3/stock-items"
        );

        $products = json_decode($res->getBody()->__toString());

        \App\Models\Product::query()->update(["enabled" => false]);

        foreach ($products as $product) {
            \App\Models\Product::withoutGlobalScopes()->updateOrCreate(
                ["id" => $product->id],
                [
                    "enabled" => true,
                    "published" => false,
                    "name" => $product->name ?? null,
                    "price" => $product->price ?? null,
                    "postage" => $product->postageAndPacking ?? null,
                    "type" => $product->attribute_HPPHStockType ?? null,
                ]
            );
        }
    }
}
