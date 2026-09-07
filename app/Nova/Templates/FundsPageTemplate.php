<?php

namespace App\Nova\Templates;

use App\Nova\Flexible\Layouts\FundGroupLayout;
use App\Nova\Flexible\Layouts\ImageLayout;
use App\Nova\Flexible\Layouts\ImagePairLayout;
use App\Nova\Flexible\Layouts\JournalPostLayout;
use App\Nova\Flexible\Layouts\LinkBannerLayout;
use App\Nova\Flexible\Layouts\PagesLayout;
use App\Nova\Flexible\Layouts\QuoteLayout;
use App\Nova\Flexible\Layouts\SingleMembershipLayout;
use App\Nova\Flexible\Layouts\TeamLayout;
use App\Nova\Flexible\Layouts\TextLayout;
use Illuminate\Http\Request;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class FundsPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return 'Funds page';
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel('Page content', [
                Flexible::make('Content', 'content')
                    ->addLayout(
                        FundGroupLayout::class
                    )
                    ->addLayout(TextLayout::class)
                    ->addLayout(ImageLayout::class)
                    ->addLayout(
                        ImagePairLayout::class
                    )
                    ->addLayout(
                        JournalPostLayout::class
                    )
                    ->addLayout(
                        SingleMembershipLayout::class
                    )
                    ->addLayout(TeamLayout::class)
                    ->addLayout(PagesLayout::class)
                    ->addLayout(QuoteLayout::class)
                    ->addLayout(
                        LinkBannerLayout::class
                    )

                    ->button('Add new block')
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
