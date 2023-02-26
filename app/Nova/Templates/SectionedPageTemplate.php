<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Template;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Panel;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Whitecube\NovaFlexibleContent\Flexible;
use Illuminate\Support\Facades\Vite;

class SectionedPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Sectioned page";
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel("Page content", [
                Text::make("Banner text", "content->banner_text")
                    ->maxlength(20)
                    ->enforceMaxlength(),
                Flexible::make("Content", "content->flexible")
                    ->addLayout(\App\Nova\Flexible\Layouts\SectionLayout::class)
                    ->button("Add a section")
                    ->stacked(),
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
