<?php

namespace App\Nova\Flexible\Layouts;

use App\Nova\Actions\SaveAndResizeBannerImage;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Spatie\MediaLibrary\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class SectionLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'section';

    public $collapsedPreviewAttribute = 'title';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Section';

    public function getSectionedContentAttribute()
    {
        return $this->flexible('sectioned_content', [
            'simple-text' => SimpleTextLayout::class,
            'single-faq' => SingleFaqLayout::class,
        ]);
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Image::make('Image', 'banner')
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->store(new SaveAndResizeBannerImage),
            Text::make('Title'),
            Flexible::make('Content', 'sectioned_content')
                ->stacked()
                ->fullWidth()
                ->addLayout(SimpleTextLayout::class)
                ->addLayout(SingleFaqLayout::class),
        ];
    }
}
