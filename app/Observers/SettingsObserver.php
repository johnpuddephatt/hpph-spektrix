<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class SettingsObserver
{
    /**
     * Handle the MenuItem "created" event.
     * @return void
     */
    public function created()
    {
        Cache::forget("settings");
    }

    /**
     * Handle the MenuItem "updated" event.
     * @return void
     */
    public function updated()
    {
        logger("wow");
        Cache::forget("settings");
    }

    /**
     * Handle the MenuItem "deleted" event.
     * @return void
     */
    public function deleted()
    {
        Cache::forget("settings");
    }

    /**
     * Handle the MenuItem "restored" event.
     * @return void
     */
    public function restored()
    {
        Cache::forget("settings");
    }

    /**
     * Handle the MenuItem "force deleted" event.
     * @return void
     */
    public function forceDeleted()
    {
        Cache::forget("settings");
    }

    /**
     * Handle the MenuItem "saving" event.
     * @return void
     */
    public function saving()
    {
        Cache::forget("settings");
    }
}
