<?php

namespace App\Jobs;

use App\Models\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Warms the Spatie response cache for the busiest pages.
 *
 * The package has no warmer, and the response cache can only be populated by a
 * genuine web request — CacheAllSuccessfulGetRequests refuses to cache anything
 * while runningInConsole(), so rendering in-process through the kernel would
 * silently cache nothing. Hence curl.
 *
 * Two things the previous attempt lacked, which is why it "didn't seem to work"
 * with no way to tell why:
 *
 *  - It resolves the public hostname straight to the origin, so the request cannot
 *    be answered by anything sitting in front of the app.
 *  - It logs every URL and status. Previously it echoed them, and echo output from
 *    a queued job goes nowhere.
 *
 * The Host header must match what real visitors send, because App\Cache\Hasher keys
 * the cache on $request->getHost(). A mismatch warms entries under a key nobody
 * ever reads.
 */
class CachePages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $base = rtrim(config('app.url'), '/');
        $host = parse_url($base, PHP_URL_HOST);
        $scheme = parse_url($base, PHP_URL_SCHEME) ?: 'https';

        if (! $host) {
            Log::channel('spektrix')->error('CachePages: APP_URL has no host, cannot warm');

            return;
        }

        $warmed = 0;
        $failed = 0;

        foreach ($this->paths() as $path) {
            $url = $base.$path;
            [$status, $error] = $this->request($url, $host, $scheme);

            if ($status >= 200 && $status < 300) {
                $warmed++;
                Log::channel('spektrix')->info("CachePages: {$url} -> {$status}");
            } else {
                $failed++;
                Log::channel('spektrix')->warning(
                    "CachePages: {$url} -> {$status}".($error ? " ({$error})" : '')
                );
            }
        }

        Log::channel('spektrix')->info("CachePages: warmed {$warmed}, failed {$failed}");
    }

    /**
     * Paths worth warming, resolved from the CMS rather than hardcoded so a
     * renamed page does not silently stop being warmed.
     */
    protected function paths(): array
    {
        $programme = Page::getTemplateUrl('programme-page');

        return array_values(array_filter([
            '/',
            $programme,
            $programme ? $programme.'?type=schedule' : null,
            $programme ? $programme.'?type=alphabetical' : null,
        ]));
    }

    /**
     * @return array{0: int, 1: ?string} status code and any transport error
     */
    protected function request(string $url, string $host, string $scheme): array
    {
        $port = $scheme === 'https' ? 443 : 80;
        $origin = config('app.origin_ip', '127.0.0.1');

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 60,
            // Straight to the origin, so nothing in front of the app can answer
            // this and leave the origin cache unwarmed.
            CURLOPT_RESOLVE => ["{$host}:{$port}:{$origin}"],
            // Warming talks to the origin by IP, so the certificate will not match
            // the hostname. The Host header above is what the app keys on.
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => [
                "Host: {$host}",
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: en-GB,en;q=0.9',
            ],
            CURLOPT_USERAGENT => 'HPPH-CacheWarmer/1.0',
        ]);

        curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch) ?: null;
        curl_close($ch);

        return [$status, $error];
    }
}
