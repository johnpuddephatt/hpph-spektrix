<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class StrandObserver
{
    /**
     * Handle the MenuItem "created" event.
     * @return void
     */
    public function created()
    {
        Cache::flush();
    }

    /**
     * Handle the MenuItem "updated" event.
     * @return void
     */
    public function updated()
    {
        Cache::flush();
    }

    /**
     * Handle the MenuItem "deleted" event.
     * @return void
     */
    public function deleted()
    {
        Cache::flush();
    }

    /**
     * Handle the MenuItem "restored" event.
     * @return void
     */
    public function restored()
    {
        Cache::flush();
    }

    /**
     * Handle the MenuItem "force deleted" event.
     * @return void
     */
    public function forceDeleted()
    {
        Cache::flush();
    }

    /**
     * Handle the MenuItem "saving" event.
     * @return void
     */
    public function saving()
    {
        Cache::flush();
    }
}
