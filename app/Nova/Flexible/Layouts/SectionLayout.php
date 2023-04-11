<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Whitecube\NovaFlexibleContent\Flexible;

class SectionLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "section";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Section";

    public function getSectionContentAttribute()
    {
        return $this->flexible("section_content", [
            "simple-text" => \App\Nova\Flexible\Layouts\SimpleTextLayout::class,
            "single-faq" => \App\Nova\Flexible\Layouts\SingleFaqLayout::class,
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
            Image::make("Image", "banner")
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->store(new \App\Nova\Actions\SaveAndResizeBannerImage()),
            Text::make("Title"),
            Flexible::make("Content", "section_content")
                ->addLayout(\App\Nova\Flexible\Layouts\SimpleTextLayout::class)
                ->addLayout(\App\Nova\Flexible\Layouts\SingleFaqLayout::class),
        ];
    }
}
