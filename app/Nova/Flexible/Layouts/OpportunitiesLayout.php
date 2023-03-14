<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Heading;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class OpportunitiesLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "opportunities";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Opportunities";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Heading::make("There are no settings for this block")->asHtml(),
        ];
    }

    public function getOpportunitiesAttribute()
    {
        return \App\Models\Opportunity::latest()->get();
    }
}
