<?php

namespace App\Nova\Flexible\Layouts;

use App\Nova\Event;
use App\Nova\Season;
use App\Nova\Strand;
use Astrotomic\CachableAttributes\CachesAttributes;
use Laravel\Nova\Fields\File;
use Outl1ne\MultiselectField\Multiselect;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class HomeHeroLayout extends Layout
{
    // use CachesAttributes;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'home-hero';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Home Hero';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Multiselect::make('Films', 'featured_events')
                ->max(5)
                ->reorderable()
                ->asyncResource(Event::class)
                ->saveAsJSON()
                ->help(
                    '<style>.multiselect__tag { display: block; padding: 10px 20px 10px 5px !important; margin-bottom: 5px !important} .multiselect__tag-icon { line-height: 32px; } .multiselect__tag-icon:after { font-size: 20px;}</style>'
                ),

            Multiselect::make('Strands', 'featured_strands')
                ->max(5)
                ->reorderable()
                ->asyncResource(Strand::class)
                ->saveAsJSON(),

            Multiselect::make('Seasons', 'featured_seasons')
                ->max(5)
                ->reorderable()
                ->asyncResource(Season::class)
                ->saveAsJSON(),

            File::make('Animation')
                ->disk('public')
                ->acceptedTypes('.json')
                ->help('')
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

        $events = \App\Models\Event::shownInProgramme()->hasFutureInstances()->whereIn(
            'id',
            $this->featured_events ?? []
        )->with('featuredImage', 'featuredVideo')->get();
        $seasons = \App\Models\Season::whereIn(
            'id',
            $this->featured_seasons ?? []
        )->with('featuredImage', 'featuredVideo')->get();
        $strands = \App\Models\Strand::whereIn(
            'id',
            $this->featured_strands ?? []
        )->with('featuredImage', 'featuredVideo')->get();

        if (
            $events->count() || $seasons->count() || $strands->count()
        ) {
            return $events->toBase()->concat($seasons->toBase())->concat($strands->toBase())->random();
        } else {
            return \App\Models\Event::shownInProgramme()->hasFutureInstances()
                ->with('featuredImage', 'featuredVideo')
                ->orderBy('first_instance_date_time', 'DESC')
                ->limit(3)
                ->get()->random();
        }
    }
}
