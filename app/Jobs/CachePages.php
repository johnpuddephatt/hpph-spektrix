<?php

namespace App\Jobs;

use App\Models\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class CachePages implements ShouldQueue
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
        $routes = [
            url('/'),
            url('/whats-on'),
            url('/whats-on?type=schedule'),
            url('/whats-on?type=alphabetical'),
        ];



        foreach ($routes as $route) {

            try {
                // $response = Http::get($route);
                $client = new Client();
                $response = $client->get($route, [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (compatible; CacheWarmer)',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                        // Add other headers that match your typical requests
                    ]
                ]);

                echo "{$route} –––– Status: {$response->status()} \n";
            } catch (\Exception $e) {
                echo "{$route} –––– Failed: {$e->getMessage()} \n";
            }

            sleep(5);
        }
        Log::info("Cached response data for " . count($routes) . " routes.");
        Log::info('Pre-caching complete!');
    }
}
