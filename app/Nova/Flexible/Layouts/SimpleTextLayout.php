<?php namespace App\Nova\Flexible\Layouts;

use Advoor\NovaEditorJs\NovaEditorJsCast;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class SimpleTextLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "simple-text";

    protected $casts = [
        "section_content" => NovaEditorJsCast::class,
    ];

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Text";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            NovaEditorJsField::make(
                "Content",
                "section_content"
            )->hideFromDetail(),
        ];
    }
}
