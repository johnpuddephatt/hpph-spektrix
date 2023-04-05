<?php namespace App\Nova\Flexible\Layouts;

use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class FeatureLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "feature";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Feature";

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
                ->store(new \App\Nova\Actions\SaveAndResizeFeatureImage()),
            Text::make("Title", "title"),
            Textarea::make("Description", "description"),
        ];
    }
}
