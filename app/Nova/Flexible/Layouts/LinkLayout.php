<?php namespace App\Nova\Flexible\Layouts;

use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class LinkLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "link";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Link";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Image::make("Image", "image")
                ->disk("public")
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->store(new \App\Nova\Actions\SaveAndResizeExternalLinkImage()),
            Text::make("Title", "title"),
            Textarea::make("Description", "description"),
            Text::make("URL", "url"),
        ];
    }
}
