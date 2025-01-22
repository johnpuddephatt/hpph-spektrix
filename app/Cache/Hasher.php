<?php

namespace App\Cache;

use Spatie\ResponseCache\Hasher\RequestHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\ResponseCache\CacheProfiles\CacheProfile;

class Hasher implements RequestHasher
{
    public function __construct(
        protected CacheProfile $cacheProfile,
    ) {
        //
    }

    public function getHashFor(Request $request): string
    {
        $cacheNameSuffix = $this->getCacheNameSuffix($request);

        return 'responsecache-' . hash(
            'xxh128',
            "{$request->getHost()}-{$this->getNormalizedRequestUri($request)}-{$request->getMethod()}/$cacheNameSuffix"
        );
    }

    protected function getNormalizedRequestUri(Request $request): string
    {

        if ($queryParams = $request->query()) {
            $queryParams = collect($request->query())
                ->reject(fn($value, $key) => Str::startsWith($key, 'utm_'))
                ->reject(fn($value, $key) => Str::startsWith($key, 'dm_'))
                ->toArray();
            if (!empty($queryParams)) {
                $queryString = http_build_query($queryParams);
                $queryString = '?' . $queryString;
            }
        }

        return $request->getBaseUrl() . $request->getPathInfo() . ($queryString ?? '');
    }

    protected function getCacheNameSuffix(Request $request)
    {
        if ($request->attributes->has('responsecache.cacheNameSuffix')) {
            return $request->attributes->get('responsecache.cacheNameSuffix');
        }

        return $this->cacheProfile->useCacheNameSuffix($request);
    }
}
