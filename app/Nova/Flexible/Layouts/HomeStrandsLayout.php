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

class HomeStrandsLayout extends Layout
{
    // use CachesAttributes;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "home-strands";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Home Strands";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields() {}
}
