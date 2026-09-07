<?php

namespace App\Providers;

use App\Listeners\MediaConversionComplete;
use App\Models\AccessTag;
use App\Models\Fund;
use App\Models\Membership;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Season;
use App\Models\SignupForm;
use App\Models\SpektrixStatement;
use App\Models\SpektrixTag;
use App\Models\SpektrixTagGroup;
use App\Models\Strand;
use App\Models\TicketSubscription;
use App\Observers\AccessTagsObserver;
use App\Observers\MediaObserver;
use App\Observers\MenuObserver;
use App\Observers\ModelObserver;
use App\Observers\SettingsObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Outl1ne\MenuBuilder\Models\Menu;
use Outl1ne\MenuBuilder\Models\MenuItem;
use Outl1ne\NovaSettings\Models\Settings;
use Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompleted;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class],
        ConversionHasBeenCompleted::class => [
            MediaConversionComplete::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Settings::observe(
            SettingsObserver::class
        );
        MenuItem::observe(
            MenuObserver::class
        );
        Menu::observe(
            MenuObserver::class
        );
        Media::observe(
            MediaObserver::class
        );

        Strand::observe(ModelObserver::class);
        Season::observe(ModelObserver::class);
        Page::observe(ModelObserver::class);
        \App\Models\Event::observe(ModelObserver::class);
        Post::observe(ModelObserver::class);

        // These are rendered on the funds, memberships and shop pages but were not
        // observed. Their imports only ever invalidated because FetchEventData used
        // to flush unconditionally; now that it clears only on change, they need to
        // account for themselves.
        Fund::observe(ModelObserver::class);
        Membership::observe(ModelObserver::class);
        Product::observe(ModelObserver::class);
        TicketSubscription::observe(
            ModelObserver::class
        );

        // Editing a form, or a sync changing the available tags, must clear the
        // response cache so pages carrying the signup block re-render.
        SignupForm::observe(ModelObserver::class);
        SpektrixTag::observe(ModelObserver::class);
        SpektrixTagGroup::observe(ModelObserver::class);
        SpektrixStatement::observe(ModelObserver::class);

        AccessTag::observe(AccessTagsObserver::class);
    }
}
