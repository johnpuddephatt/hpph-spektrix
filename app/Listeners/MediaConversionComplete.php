<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Cache;

class MediaConversionComplete
{
    public function handle()
    {
        Cache::clear();
    }
}
