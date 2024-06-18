<?php

namespace App\Nova\Flexible\Layouts;

use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Number;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Outl1ne\MultiselectField\Multiselect;

class HomeHeroLayout extends Layout
{
    // use CachesAttributes;

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
            Multiselect::make("Films", "featured_events")
                ->max(5)
                ->reorderable()
                ->asyncResource(\App\Nova\Event::class)
                ->saveAsJSON()
                ->help(
                    "<style>.multiselect__tag { display: block; padding: 10px 20px 10px 5px !important; margin-bottom: 5px !important} .multiselect__tag-icon { line-height: 32px; } .multiselect__tag-icon:after { font-size: 20px;}</style>"
                ),

            File::make("Animation")
                ->disk("public")
                ->acceptedTypes(".json")
                ->help("")
                ->storeAs(function ($request) {
                    return $request->animation->getClientOriginalName();
                }),
        ];
    }
    public function getEventAttribute()
    {
        if (\App\Models\Event::shownInProgramme()->hasFutureInstances()->count() == 0) {
            return null;
        }

        if (
            \App\Models\Event::shownInProgramme()->hasFutureInstances()->whereIn(
                "id",
                $this->featured_events ?? []
            )->count()
        ) {
            return \App\Models\Event::shownInProgramme()->hasFutureInstances()->with("featuredImage", "featuredVideo")->whereIn("id", $this->featured_events)->get()->random();
        } else {
            return \App\Models\Event::shownInProgramme()->hasFutureInstances()
                ->with("featuredImage", "featuredVideo")

                ->orderBy("first_instance_date_time", "DESC")
                ->limit(3)
                ->get()
                ->random();
        }
    }
}
