<?php

namespace App\Nova\Templates;

use App\Nova\Flexible\Layouts\ImageLayout;
use App\Nova\Flexible\Layouts\ImagePairLayout;
use App\Nova\Flexible\Layouts\JournalPostLayout;
use App\Nova\Flexible\Layouts\LinkBannerLayout;
use App\Nova\Flexible\Layouts\PagesLayout;
use App\Nova\Flexible\Layouts\QuoteLayout;
use App\Nova\Flexible\Layouts\SignupFormLayout;
use App\Nova\Flexible\Layouts\SingleMembershipLayout;
use App\Nova\Flexible\Layouts\TeamLayout;
use App\Nova\Flexible\Layouts\TextLayout;
use App\Nova\Flexible\Layouts\TicketSubscriptionGroupLayout;
use App\Nova\Templates\Concerns\HasPageMenuSetting;
use Illuminate\Http\Request;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class StandardPageTemplate
{
    use HasPageMenuSetting;

    // Name displayed in CMS
    public function name(): string
    {
        return 'Standard page';
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            $this->pageMenuField(),

            new Panel('Content', [
                Flexible::make('Content', 'content')
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
                    ->addLayout(
                        SignupFormLayout::class
                    )
                    ->addLayout(
                        TicketSubscriptionGroupLayout::class
                    )

                    ->button('Add a section')
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
