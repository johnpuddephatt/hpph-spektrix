<?php

namespace App\Nova\Flexible\Layouts;

use Advoor\NovaEditorJs\NovaEditorJsCast;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Whitecube\NovaFlexibleContent\Flexible;

class SingleFaqLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "single-faq";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Single FAQ";

    protected $casts = [
        "answer" => NovaEditorJsCast::class,
    ];

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [Text::make("Question"), NovaEditorJsField::make("Answer")];
    }
}
