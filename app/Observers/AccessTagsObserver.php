<?php

namespace App\Observers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

class AccessTagsObserver
{

    public function clearCache()
    {
        Cache::forget("access_tags");
        Artisan::call('route:cache');
        ResponseCache::clear();
    }
    /**
     * Handle the MenuItem "created" event.
     * @return void
     */
    public function created()
    {
        $this->clearCache();
    }

    /**
     * Handle the MenuItem "updated" event.
     * @return void
     */
    public function updated()
    {
        $this->clearCache();
    }

    /**
     * Handle the MenuItem "deleted" event.
     * @return void
     */
    public function deleted()
    {
        $this->clearCache();
    }

    /**
     * Handle the MenuItem "restored" event.
     * @return void
     */
    public function restored()
    {
        $this->clearCache();
    }

    /**
     * Handle the MenuItem "force deleted" event.
     * @return void
     */
    public function forceDeleted()
    {
        $this->clearCache();
    }

    /**
     * Handle the MenuItem "saving" event.
     * @return void
     */
    public function saving()
    {
        $this->clearCache();
    }
}
