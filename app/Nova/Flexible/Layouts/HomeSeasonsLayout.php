<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class HomeSeasonsLayout extends Layout
{
    // use CachesAttributes;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'home-seasons';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Home Seasons';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Title', 'title'),
            Text::make('Subtitle', 'subtitle'),
            Boolean::make('Randomise order', 'randomize'),

        ];
    }
}
