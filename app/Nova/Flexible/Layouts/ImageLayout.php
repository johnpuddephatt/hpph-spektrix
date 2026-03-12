<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Boolean;

class ImageLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "image";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Image";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Boolean::make('Short height', 'short_height'),
            Image::make("Image", "image")
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->store(new \App\Nova\Actions\SaveAndResizeFullwidthImage()),
            Text::make("Caption", "caption"),
        ];
    }
}
