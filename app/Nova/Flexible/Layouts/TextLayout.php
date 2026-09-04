<?php

namespace App\Nova\Flexible\Layouts;

use Advoor\NovaEditorJs\NovaEditorJsCast;
use App\Nova\Flexible\Layouts\Concerns\AppearsInPageMenu;
use App\Nova\Flexible\Layouts\Concerns\HasPageMenuEntry;
use Illuminate\Support\Str;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class TextLayout extends Layout implements HasPageMenuEntry
{
    use AppearsInPageMenu;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "text";

    public $collapsedPreviewAttribute = 'title';


    protected $casts = [
        "section_content" => NovaEditorJsCast::class,
    ];

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Text";

    public function menuLabel(): ?string
    {
        // The menu entry links to this section's heading, so an untitled
        // section has nothing to anchor to and isn't listed.
        if (!$title = $this->getAttribute("title")) {
            return null;
        }

        // Section headings on the history pages read "Chapter one: the
        // beginning" — the menu has always shown the part before the colon.
        return (string) Str::of($title)->before(":");
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make("Title"),
            Text::make("Subtitle"),
            Slug::make("Slug")->from("Title")->hideFromIndex()->help('Be careful changing this if you have linked to this section as it will change the anchor link'),
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

            Select::make("Heading colour")
                ->options([
                    "text-white" => "White",
                    "text-sand-dark" => "Grey",
                    "text-yellow" => "Yellow",
                    "text-black" => "Black",
                ])
                ->displayUsingLabels(),
            Boolean::make("Center?", "is_centered"),
        ];
    }
}
