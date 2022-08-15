<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;

class BannerWithTextLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "banner_with_text";

    protected $with = ["banner"];

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Banner with text";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make("Title"),
            Text::make("Subtitle"),
            Select::make("Height")->options([
                null => "Auto",
                "min-h-[66vh]" => "Two-thirds",
                "min-h-screen" => "Full",
            ]),
            Images::make("Image", "banner"),
            Select::make("Text colour", "text_color")->options([
                "text-black" => "Black",
                "text-white" => "White",
            ]),
            Select::make("Background colour", "bg_color")->options([
                "bg-black" => "Black",
                "bg-white" => "White",
                "bg-yellow" => "Yellow",
            ]),
            Boolean::make("Overlay"),
        ];
    }

    public function getBannerAttribute()
    {
        return $this->getMedia("banner")->first();
    }
}
