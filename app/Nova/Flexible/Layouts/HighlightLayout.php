<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Textarea;
use Spatie\MediaLibrary\HasMedia;

use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;

class HighlightLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "highlight";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Highlight Layout";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Images::make("Banner"),
            Text::make("Title"),
            Textarea::make("Description")->rows(2),
        ];
    }
}
