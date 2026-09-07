<?php

namespace App\Nova\Templates;

use App\Nova\Flexible\Layouts\HomeCarouselLayout;
use App\Nova\Flexible\Layouts\HomeHeroLayout;
// use Whitecube\NovaFlexibleContent\Flexible;

use App\Nova\Flexible\Layouts\HomeInstancesLayout;
use App\Nova\Flexible\Layouts\HomeSeasonsLayout;
use App\Nova\Flexible\Layouts\HomeStrandsLayout;
use App\Nova\Flexible\Layouts\JournalPostLayout;
use App\Nova\Flexible\Layouts\JournalPostsLayout;
use Illuminate\Http\Request;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class HomePageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return 'Home page';
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel('Content', [
                Flexible::make('Content', 'content')
                    ->drawer()
                    ->addLayout(
                        HomeHeroLayout::class
                    )
                    ->addLayout(
                        HomeCarouselLayout::class
                    )
                    ->addLayout(
                        HomeInstancesLayout::class
                    )
                    ->addLayout(
                        JournalPostLayout::class
                    )
                    ->addLayout(
                        JournalPostsLayout::class
                    )
                    ->addLayout(
                        HomeStrandsLayout::class
                    )
                    ->addLayout(
                        HomeSeasonsLayout::class
                    ),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return $page->content;
    }

    // Optional suffix to the route (ie {blogPostName})
    public function pathSuffix(): ?string
    {
        return null;
    }
}
