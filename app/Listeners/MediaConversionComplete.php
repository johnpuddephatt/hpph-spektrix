<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Spatie\ResponseCache\Facades\ResponseCache;

class MediaConversionComplete
{
    public function handle()
    {
        Log::info("Media conversion complete event");
        Cache::clear();
        ResponseCache::clear();
    }
}
