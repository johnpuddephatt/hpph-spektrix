<?php namespace App\Nova\Flexible\Layouts;

use Advoor\NovaEditorJs\NovaEditorJsCast;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class TextLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "text";

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
            Text::make("Title"),
            NovaEditorJsField::make(
                "Content",
                "section_content"
            )->hideFromDetail(),
            Heading::make("Settings"),
            Select::make("Background colour")
                ->options([
                    "bg-white" => "White",
                    "bg-sand" => "Grey",
                    "bg-yellow" => "Yellow",
                    "bg-black" => "Black",
                ])
                ->displayUsingLabels(),
            Boolean::make("Center?", "is_centered"),
        ];
    }
}
