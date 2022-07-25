<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;

class ImageCarouselLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "image_carousel";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Image Carousel";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
                // "title" => $this->attributes["title"],
            ];
    }
}
