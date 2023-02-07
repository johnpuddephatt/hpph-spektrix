<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class ModelObserver
{
    /**
     * Handle the Model "created" event.
     * @return void
     */
    public function created()
    {
        Cache::flush();
    }

    /**
     * Handle the Model "updated" event.
     * @return void
     */
    public function updated()
    {
        Cache::flush();
    }

    /**
     * Handle the Model "deleted" event.
     * @return void
     */
    public function deleted()
    {
        Cache::flush();
    }

    /**
     * Handle the Model "restored" event.
     * @return void
     */
    public function restored()
    {
        Cache::flush();
    }

    /**
     * Handle the Model "force deleted" event.
     * @return void
     */
    public function forceDeleted()
    {
        Cache::flush();
    }

    /**
     * Handle the Model "saving" event.
     * @return void
     */
    public function saving()
    {
        Cache::flush();
    }
}
