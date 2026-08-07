<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    */

    'default' => env('CACHE_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    | Supported drivers: "apc", "array", "database", "file",
    |         "memcached", "redis", "dynamodb", "octane", "null"
    |
    */

    'stores' => [

        'apc' => [
            'driver' => 'apc',
        ],

        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => null,
            'lock_connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],

        /*
         * Per-instance ticket availability, kept out of the default store.
         *
         * This data is expensive — one Spektrix HTTP call per instance — and is
         * refreshed on its own five-minute schedule by cache:availability. It has
         * nothing to do with editorial content, so a content change must not be
         * able to wipe it: a cold availability cache leaves the next visitor's
         * What's On render with no seat numbers until the next scheduled refresh.
         *
         * Note the dedicated redis *connection*, not just a prefix. RedisStore
         * flushes with flushdb(), which empties the whole database and ignores
         * prefixes — so sharing the 'cache' connection would mean every
         * Cache::flush() wiped this too.
         */
        'availability' => [
            'driver' => env('AVAILABILITY_CACHE_DRIVER', env('CACHE_DRIVER', 'file')),
            'path' => storage_path('framework/cache/availability'),
            'connection' => 'availability',
            'prefix' => 'availability',
        ],

        /*
         * Full-page responses. Its own database for the same reason: otherwise
         * `artisan responsecache:clear` on deploy flushes the entire cache
         * database, taking the application cache and availability with it.
         */
        'response_cache' => [
            'driver' => env('CACHE_DRIVER', 'file'),
            'path' => storage_path('framework/cache/responses'),
            'connection' => 'response_cache',
            'prefix' => 'responsecache',
        ],

        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'lock_connection' => 'default',
        ],

        'dynamodb' => [
            'driver' => 'dynamodb',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => env('DYNAMODB_ENDPOINT'),
        ],

        'octane' => [
            'driver' => 'octane',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing a RAM based store such as APC or Memcached, there might
    | be other applications utilizing the same cache. So, we'll specify a
    | value to get prefixed to all our keys so we can avoid collisions.
    |
    */

    'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_cache'),

];
