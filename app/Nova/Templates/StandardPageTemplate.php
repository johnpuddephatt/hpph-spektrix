<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Template;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

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
                Flexible::make("Content", "content")
                    ->addLayout(\App\Nova\Flexible\Layouts\TextLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\ImageLayout::class)
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\ImagePairLayout::class
                    )
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\JournalPostLayout::class
                    )
                    ->addLayout(\App\Nova\Flexible\Layouts\TeamLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\PagesLayout::class)
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\LinkBannerLayout::class
                    )
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
}
