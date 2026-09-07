<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Instance;
use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class HomeInstancesLayout extends Layout implements CachableAttributes
{
    use CachesAttributes;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'home-instances';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Home Instances';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [Text::make('Title')];
    }

    public function getInstancesAttribute()
    {

        return Instance::take(16)
            ->whereHas('event', function (Builder $query) {
                return $query->shownInProgramme();
            })
            ->with('event.featuredImage', 'strands')
            ->get();
    }
}
