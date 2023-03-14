<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;

class ImageCarouselLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;

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

    protected $with = ["gallery"];

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [Images::make("Image gallery", "gallery")];
    }

    public function getGalleryAttribute()
    {
        return $this->getMedia("gallery")
            ->shuffle()
            ->take(5);
    }
}
