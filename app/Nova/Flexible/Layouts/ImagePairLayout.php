<?php

namespace App\Nova\Flexible\Layouts;

use Illuminate\Support\Facades\Storage;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;

class ImagePairLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "image-pair";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Image pair";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Image::make("Image", "image")
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->store(new \App\Nova\Actions\SaveAndResizeSquareImage()),
            Image::make("Image", "image_2")
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->store(new \App\Nova\Actions\SaveAndResizeSquareImage()),
        ];
    }
}
