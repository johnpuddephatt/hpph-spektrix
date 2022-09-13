<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Template;
use Laravel\Nova\Panel;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Outl1ne\MultiselectField\Multiselect;
use Whitecube\NovaFlexibleContent\Flexible;

class JobsPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Jobs and Opportunities";
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel("Header gallery", [
                Images::make("Image gallery", "gallery"),
            ]),
            new Panel("Welcome", [
                Textarea::make("Welcome text", "content->welcome_text")->rows(
                    3
                ),
            ]),
            new Panel("Highlights", [
                Flexible::make("Highlight", "content->highlights")
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\HighlightLayout::class
                    )
                    ->button("Add a highlight")
                    ->limit(3),
            ]),
            new Panel("Image", [Images::make("Image", "secondary")]),

            new Panel("Pages", [
                Multiselect::make("Pages", "content->child_pages")
                    ->options(
                        \App\Models\Page::find($request->resourceId)
                            ->children()
                            ->pluck("name", "id")
                    )
                    ->max(2)
                    ->saveAsJSON()
                    ->reorderable(),
            ]),

            new Panel("Banner", [
                Text::make("Title", "content->banner->title"),
                Text::make("Subtitle", "content->banner->subtitle"),
                Select::make("Height", "content->banner->height")->options([
                    null => "Auto",
                    "min-h-[66vh]" => "Two-thirds",
                    "min-h-screen" => "Full",
                ]),
                Images::make("Image", "banner"),
                Boolean::make("Overlay", "content->banner->overlay"),
                Select::make("Text colour", "content->banner->text_color")
                    ->options([
                        "text-black" => "Black",
                        "text-white" => "White",
                    ])
                    ->displayUsingLabels(),
                Select::make("Background colour", "content->banner->bg_color")
                    ->options([
                        "bg-black" => "Black",
                        "bg-white" => "White",
                        "bg-yellow" => "Yellow",
                    ])
                    ->displayUsingLabels(),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page, $params): array
    {
        // Modify data as you please (ie turn ID-s into models)
        return $page->data;
    }

    // Optional suffix to the route (ie {blogPostName})
    public function pathSuffix(): string|null
    {
        return null;
    }
}
