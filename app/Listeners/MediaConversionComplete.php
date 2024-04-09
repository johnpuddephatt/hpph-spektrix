<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

class MediaConversionComplete
{
    public function handle()
    {
        Cache::clear();
        ResponseCache::clear();
    }
}
