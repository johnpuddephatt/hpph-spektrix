<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Panel;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\MultiSelect;
use Whitecube\NovaFlexibleContent\Flexible;

class FundsPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Funds page";
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel("Page content", [
                Flexible::make("Content", "content")
                    ->addLayout("Fund group", "fund_group", [
                        Text::make("Fund group title"),
                        MultiSelect::make("Funds")->options(
                            \App\Models\Fund::pluck("name", "id")
                        ),
                    ])
                    ->button("Add new fund group"),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return $page->content;
    }

    // Optional suffix to the route (ie {blogPostName})
    public function pathSuffix(): string|null
    {
        return null;
    }
}
