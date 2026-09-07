<?php

namespace App\Nova\Flexible\Layouts;

use App\Nova\Actions\SaveAndResizeBannerImage;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class BannerLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'banner';

    public $collapsedPreviewAttribute = 'title';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Banner (link)';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Title', 'title'),
            Text::make('Subtitle', 'subtitle'),
            Text::make('URL', 'url'),
            Text::make('Link text', 'link_text'),
            Text::make('Label', 'label'),
            Image::make('Image', 'banner')
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->store(new SaveAndResizeBannerImage),
        ];
    }
}
