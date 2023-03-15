<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Template;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class ShopPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Shop page";
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
                // new Panel("Content", [
                //     Flexible::make("Content", "content")
                //         ->addLayout(\App\Nova\Flexible\Layouts\TextLayout::class)
                //         ->button("Add a section")
                //         ->stacked(),
                // ]),
            ];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return $page->content;
    }
}
