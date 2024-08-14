<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Panel;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\MultiSelect;
use Whitecube\NovaFlexibleContent\Flexible;

class MembershipsPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Memberships page";
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel("Page content", [
                Flexible::make("", "content")
                    ->addLayout(\App\Nova\Flexible\Layouts\TextLayout::class)
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\MembershipComparisonLayout::class
                    )
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\FeaturedMembershipLayout::class
                    )
                    ->addLayout(\App\Nova\Flexible\Layouts\ImageLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\FaqsLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\PagesLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\BannerLayout::class)
                    ->fullWidth()
                    ->button("Add new section"),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return $page->content;
    }
}
