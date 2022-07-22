<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Number;
use Illuminate\Support\Facades\Cache;

class HomeHeroLayout extends Layout
{
    // protected $appends = ["posts", "events"];

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "home_hero";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Home Hero";

    public function getPostsAttribute()
    {
        return Cache::remember("home_posts", 3600, function () {
            return \App\Models\Post::with("featuredImage")
                ->latest()
                ->take(3)
                ->get();
        });
    }

    public function getEventsAttribute()
    {
        return Cache::remember("home_events", 3600, function () {
            return \App\Models\Event::with(
                "featuredImage",
                "instances.strand",
                "instances.season"
            )
                ->take(4)
                ->get()
                ->map(function ($event) {
                    $event->strands = $event->instances
                        ->pluck("strand")
                        ->unique()
                        ->flatten()
                        ->filter();
                    $event->seasons = $event->instances
                        ->pluck("season")
                        ->unique()
                        ->flatten()
                        ->filter();
                    return $event;
                });
        });
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [Number::make("Number of posts")];
    }
}
