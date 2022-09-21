<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     * @return void
     */
    public function created()
    {
        Cache::flush();
    }

    /**
     * Handle the Event "updated" event.
     * @return void
     */
    public function updated()
    {
        Cache::flush();
    }

    /**
     * Handle the Event "deleted" event.
     * @return void
     */
    public function deleted()
    {
        Cache::flush();
    }

    /**
     * Handle the Event "restored" event.
     * @return void
     */
    public function restored()
    {
        Cache::flush();
    }

    /**
     * Handle the Event "force deleted" event.
     * @return void
     */
    public function forceDeleted()
    {
        Cache::flush();
    }

    /**
     * Handle the Event "saving" event.
     * @return void
     */
    public function saving()
    {
        Cache::flush();
    }
}
