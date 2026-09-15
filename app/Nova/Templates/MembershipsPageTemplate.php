<?php

namespace App\Nova\Templates;

use App\Nova\Flexible\Layouts\BannerLayout;
use App\Nova\Flexible\Layouts\FaqsLayout;
use App\Nova\Flexible\Layouts\FeaturedMembershipLayout;
use App\Nova\Flexible\Layouts\ImageLayout;
use App\Nova\Flexible\Layouts\ImagePairLayout;
use App\Nova\Flexible\Layouts\JournalPostLayout;
use App\Nova\Flexible\Layouts\MembershipComparisonLayout;
use App\Nova\Flexible\Layouts\PagesLayout;
use App\Nova\Flexible\Layouts\TextLayout;
use App\Nova\Templates\Concerns\HasPageMenuSetting;
use Illuminate\Http\Request;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class MembershipsPageTemplate
{
    use HasPageMenuSetting;

    // Name displayed in CMS
    public function name(): string
    {
        return 'Memberships page';
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            $this->pageMenuField(),

            new Panel('Page content', [
                Flexible::make('', 'content')
                    ->addLayout(TextLayout::class)
                    ->addLayout(
                        MembershipComparisonLayout::class
                    )
                    ->addLayout(
                        FeaturedMembershipLayout::class
                    )
                    ->addLayout(ImageLayout::class)
                    ->addLayout(ImagePairLayout::class)
                    ->addLayout(FaqsLayout::class)
                    ->addLayout(PagesLayout::class)
                    ->addLayout(BannerLayout::class)
                    ->addLayout(JournalPostLayout::class)
                    ->drawer()
                    ->button('Add new section'),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return $page->content;
    }
}
