<?php namespace App\Nova\Flexible\Layouts;

use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class QuoteLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "quote";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Quote";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Textarea::make("Quote", "quote")
                ->rows(3)
                ->maxLength(130)
                ->enforceMaxlength(),
            Text::make("Member name", "name")->hideFromIndex(),
            Text::make("Member role/description", "role")->hideFromIndex(),
            Image::make("Image")
                ->disk("public")
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->store(new \App\Nova\Actions\SaveAndResizeBannerImage()),
        ];
    }
}
