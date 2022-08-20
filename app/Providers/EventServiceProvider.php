<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        \Outl1ne\MenuBuilder\Models\MenuItem::observe(
            \App\Observers\MenuItemObserver::class
        );
        \Outl1ne\MenuBuilder\Models\Menu::observe(
            \App\Observers\MenuObserver::class
        );
        \App\Models\Strand::observe(\App\Observers\StrandObserver::class);
    }
}
