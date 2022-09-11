<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Template;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Panel;

class StandardPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Standard page";
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel("Content", [
                NovaEditorJsField::make("Content", "content")
                    ->stacked()
                    ->hideFromDetail(),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return json_decode($page->content);
    }

    // Optional suffix to the route (ie {blogPostName})
    public function pathSuffix(): string|null
    {
        return null;
    }
}
