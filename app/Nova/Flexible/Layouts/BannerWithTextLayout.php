<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;

class BannerWithTextLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "bannerwithtextlayout";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "BannerWithTextLayout";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            "title" => $this->attributes["title"],
            "subtitle" => $this->attributes["subtitle"],
        ];
    }
}
