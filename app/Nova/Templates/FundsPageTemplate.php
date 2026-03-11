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
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\FundGroupLayout::class
                    )
                    ->addLayout(\App\Nova\Flexible\Layouts\TextLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\ImageLayout::class)
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\ImagePairLayout::class
                    )
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\JournalPostLayout::class
                    )
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\SingleMembershipLayout::class
                    )
                    ->addLayout(\App\Nova\Flexible\Layouts\TeamLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\PagesLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\QuoteLayout::class)
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\LinkBannerLayout::class
                    )


                    ->button("Add new block")
                    ->drawer(),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return $page->content;
    }
}
