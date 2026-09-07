<?php

namespace App\Nova\Templates;

use App\Nova\Flexible\Layouts\BannerLayout;
use App\Nova\Flexible\Layouts\KeyFeaturesLayout;
use App\Nova\Flexible\Layouts\OpportunitiesLayout;
use App\Nova\Flexible\Layouts\PagesLayout;
use Illuminate\Http\Request;
use Whitecube\NovaFlexibleContent\Flexible;

class OpportunitiesPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return 'Jobs and Opportunities';
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            Flexible::make('Content', 'content')
                ->addLayout(
                    OpportunitiesLayout::class
                )
                ->addLayout(KeyFeaturesLayout::class)
                ->addLayout(PagesLayout::class)
                ->addLayout(BannerLayout::class)
                ->drawer(),
        ];
    }

    public function resolve($page)
    {
        if (! $page->content) {
            abort(404);
        }

        return $page->content;
    }
}
