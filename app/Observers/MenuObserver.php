<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

class MenuObserver
{
    /**
     * Forget menus method
     */
    public function forgetMenus()
    {
        Cache::flush();
        ResponseCache::clear();
    }

    /**
     * Handle the MenuItem "created" event.
     * @return void
     */
    public function created()
    {
        $this->forgetMenus();
    }

    /**
     * Handle the MenuItem "updated" event.
     * @return void
     */
    public function updated()
    {
        $this->forgetMenus();
    }

    /**
     * Handle the MenuItem "deleted" event.
     * @return void
     */
    public function deleted()
    {
        $this->forgetMenus();
    }

    /**
     * Handle the MenuItem "restored" event.
     * @return void
     */
    public function restored()
    {
        $this->forgetMenus();
    }

    /**
     * Handle the MenuItem "force deleted" event.
     * @return void
     */
    public function forceDeleted()
    {
        $this->forgetMenus();
    }

    /**
     * Handle the MenuItem "saving" event.
     * @return void
     */
    public function saving()
    {
        $this->forgetMenus();
    }
}
