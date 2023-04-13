<?php

namespace App\Nova\Flexible\Layouts;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Spatie\MediaLibrary\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;

class HomeCarouselLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "home-carousel";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Home Carousel";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Images::make("Image gallery", "gallery")->customPropertiesFields([
                Select::make("Category")->options([
                    "Building",
                    "History",
                    "People",
                    "Redevelopment",
                ]),
            ]),
            Text::make("Values heading", "heading"),
            Textarea::make("Values statement", "statement"),
        ];
    }

    public function getShuffledImagesAttribute()
    {
        $shuffled_images = $this->getMedia("gallery")
            ->shuffle()
            ->groupBy("custom_properties.category");

        return count($shuffled_images)
            ? $shuffled_images
                ->map(function ($values) {
                    return $values->take(2);
                })
                ->flatten()

                ->filter(function ($item) {
                    return $item->hasGeneratedConversion("square");
                })
                ->shuffle()
            : null;
    }
}
