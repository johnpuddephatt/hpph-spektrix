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

class CacheProgramme implements ShouldQueue
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


        Instance::getInstancesForProgramme(overwriteCache: true);
        Log::info("Caching programme instances");

        // $routes = [
        //     url('/'),
        //     url('/whats-on'),
        //     url('/whats-on?type=schedule'),
        //     url('/whats-on?type=alphabetical'),
        // ];

        // foreach ($routes as $route) {

        //     try {
        //         // $response = Http::get($route);

        //         // $client = new Client();
        //         // $response = $client->get($route, [
        //         //     'headers' => [
        //         //         'User-Agent' => 'Mozilla/5.0 (compatible; CacheWarmer)',
        //         //         'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        //         //         // Add other headers that match your typical requests
        //         //     ]
        //         // ]);

        //         $ch = curl_init();
        //         curl_setopt_array($ch, [
        //             CURLOPT_URL => $route,
        //             CURLOPT_RETURNTRANSFER => true,
        //             CURLOPT_FOLLOWLOCATION => true,
        //             CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        //             CURLOPT_HTTPHEADER => [
        //                 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        //                 'Accept-Language: en-US,en;q=0.5',
        //                 'Accept-Encoding: gzip, deflate',
        //                 'Connection: keep-alive',
        //             ],
        //             CURLOPT_TIMEOUT => 30,
        //             CURLOPT_SSL_VERIFYPEER => false, // Only if using HTTPS locally
        //         ]);
        //         $response = curl_exec($ch);
        //         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //         curl_close($ch);


        //         echo "{$route} –––– Status: {$httpCode} \n";
        //     } catch (\Exception $e) {
        //         echo "{$route} –––– Failed: {$e->getMessage()} \n";
        //     }

        //     sleep(3);
        // }
        // Log::info("Cached response data for " . count($routes) . " routes.");
        // Log::info('Pre-caching complete!');
    }
}
