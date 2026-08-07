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
        \Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompleted::class => [
            \App\Listeners\MediaConversionComplete::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        \Outl1ne\NovaSettings\Models\Settings::observe(
            \App\Observers\SettingsObserver::class
        );
        \Outl1ne\MenuBuilder\Models\MenuItem::observe(
            \App\Observers\MenuObserver::class
        );
        \Outl1ne\MenuBuilder\Models\Menu::observe(
            \App\Observers\MenuObserver::class
        );
        \Spatie\MediaLibrary\MediaCollections\Models\Media::observe(
            \App\Observers\MediaObserver::class
        );

        \App\Models\Strand::observe(\App\Observers\ModelObserver::class);
        \App\Models\Season::observe(\App\Observers\ModelObserver::class);
        \App\Models\Page::observe(\App\Observers\ModelObserver::class);
        \App\Models\Event::observe(\App\Observers\ModelObserver::class);
        \App\Models\Post::observe(\App\Observers\ModelObserver::class);

        // These are rendered on the funds, memberships and shop pages but were not
        // observed. Their imports only ever invalidated because FetchEventData used
        // to flush unconditionally; now that it clears only on change, they need to
        // account for themselves.
        \App\Models\Fund::observe(\App\Observers\ModelObserver::class);
        \App\Models\Membership::observe(\App\Observers\ModelObserver::class);
        \App\Models\Product::observe(\App\Observers\ModelObserver::class);

        // Editing a form, or a sync changing the available tags, must clear the
        // response cache so pages carrying the signup block re-render.
        \App\Models\SignupForm::observe(\App\Observers\ModelObserver::class);
        \App\Models\SpektrixTag::observe(\App\Observers\ModelObserver::class);
        \App\Models\SpektrixTagGroup::observe(\App\Observers\ModelObserver::class);
        \App\Models\SpektrixStatement::observe(\App\Observers\ModelObserver::class);

        \App\Models\AccessTag::observe(\App\Observers\AccessTagsObserver::class);
    }
}
