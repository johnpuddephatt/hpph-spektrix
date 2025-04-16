<?php

namespace App\Nova\Flexible\Layouts;

use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Illuminate\Database\Eloquent\Builder;

class HomeInstancesLayout extends Layout implements CachableAttributes
{
    use CachesAttributes;
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "home-instances";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Home Instances";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [Text::make("Title")];
    }
    public function getInstancesAttribute()
    {

        return \App\Models\Instance::take(16)
            ->whereHas("event", function (Builder $query) {
                return $query->shownInProgramme();
            })
            ->with("event.featuredImage", "strand")
            ->get();
    }
}
