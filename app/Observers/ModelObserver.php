<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

class ModelObserver
{
    /**
     * Handle the Model "created" event.
     * @return void
     */

    public function clearCache()
    {
        Cache::flush();
        ResponseCache::clear();
    }
    public function created()
    {
        $this->clearCache();
    }

    /**
     * Handle the Model "updated" event.
     * @return void
     */
    public function updated()
    {
        $this->clearCache();
    }

    /**
     * Handle the Model "deleted" event.
     * @return void
     */
    public function deleted()
    {
        $this->clearCache();
    }

    /**
     * Handle the Model "restored" event.
     * @return void
     */
    public function restored()
    {
        $this->clearCache();
    }

    /**
     * Handle the Model "force deleted" event.
     * @return void
     */
    public function forceDeleted()
    {
        $this->clearCache();
    }

    /**
     * Handle the Model "saving" event.
     * @return void
     */
    public function saving()
    {
        $this->clearCache();
    }
}
