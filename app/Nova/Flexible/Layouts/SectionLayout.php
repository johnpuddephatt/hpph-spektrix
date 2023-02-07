<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Spatie\MediaLibrary\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;

class SectionLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "sectionlayout";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Section";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Images::make("Banner")->fullSize(),
            Text::make("Title"),
            NovaEditorJsField::make("Content", "section_content"),
        ];
    }
}
