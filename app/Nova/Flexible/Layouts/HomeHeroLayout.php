<?php

namespace App\Nova\Flexible\Layouts;

use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Number;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Fields\Boolean;
use Outl1ne\MultiselectField\Multiselect;

class HomeHeroLayout extends Layout implements CachableAttributes
{
    use CachesAttributes;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "home-hero";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Home Hero";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Boolean::make("Randomise?", "randomise")->help(
                "If checked, the featured events will be randomised. If unchecked, the featured events will be ordered by the order they appear in the list below."
            ),
            Multiselect::make("Films", "featured_events")
                ->max(5)
                ->reorderable()
                ->asyncResource(\App\Nova\Event::class)
                ->saveAsJSON()
                ->help(
                    "<style>.multiselect__tag { display: block; padding: 10px 20px 10px 5px !important; margin-bottom: 5px !important} .multiselect__tag-icon { line-height: 32px; } .multiselect__tag-icon:after { font-size: 20px;}</style>"
                ),
        ];
    }
    public function getEventsAttribute()
    {
        return $this->remember("events", 0, function () {
            $events = (count($this->featured_events)
                ? \App\Models\Event::whereIn(
                    "id",
                    $this->featured_events
                )->orderByRaw(
                    "FIELD(id,'" . implode("','", $this->featured_events) . "')"
                )
                : \App\Models\Event::orderBy(
                    "first_instance_date_time",
                    "DESC"
                )->take(3)
            )->with(["featuredImage", "featuredVideo"]);

            if ($this->randomise) {
                return $events->get()->shuffle();
            } else {
                return $events->get();
            }
        });
    }
}
