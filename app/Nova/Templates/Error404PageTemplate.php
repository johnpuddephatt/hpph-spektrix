<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Panel;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Whitecube\NovaFlexibleContent\Flexible;

class Error404PageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "404 page";
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel("Page content", [
                Flexible::make("Content", "content")
                    ->addLayout(\App\Nova\Flexible\Layouts\FilmLayout::class)
                    ->button("Add new film"),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return $page->content;
    }
}
