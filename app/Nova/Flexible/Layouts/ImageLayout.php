<?php

namespace App\Nova\Flexible\Layouts;

use App\Nova\Actions\SaveAndResizeFullwidthImage;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class ImageLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'image';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Image';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Boolean::make('Short height', 'short_height'),
            Image::make('Image', 'image')
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->store(new SaveAndResizeFullwidthImage),
            Text::make('Caption', 'caption'),
        ];
    }
}
