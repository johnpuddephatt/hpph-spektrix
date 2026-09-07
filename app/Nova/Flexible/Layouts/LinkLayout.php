<?php

namespace App\Nova\Flexible\Layouts;

use App\Nova\Actions\SaveAndResizeExternalLinkImage;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class LinkLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'link';

    public $collapsedPreviewAttribute = 'title';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Link';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Image::make('Image', 'image')
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->store(new SaveAndResizeExternalLinkImage),
            Text::make('Title', 'title'),
            Text::make('URL', 'url'),
        ];
    }
}
