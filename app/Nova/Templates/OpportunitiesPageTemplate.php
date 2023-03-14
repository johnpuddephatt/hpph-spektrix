<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Template;
use Laravel\Nova\Panel;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Outl1ne\MultiselectField\Multiselect;
use Whitecube\NovaFlexibleContent\Flexible;

class OpportunitiesPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Jobs and Opportunities";
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            Flexible::make("Content", "content")
                ->addLayout(
                    \App\Nova\Flexible\Layouts\OpportunitiesLayout::class
                )
                ->addLayout(\App\Nova\Flexible\Layouts\KeyFeaturesLayout::class)
                ->addLayout(\App\Nova\Flexible\Layouts\PagesLayout::class)
                ->addLayout(\App\Nova\Flexible\Layouts\BannerLayout::class),
        ];
    }

    public function resolve($page)
    {
        if (!$page->content) {
            abort(404);
        }

        return $page->content;
    }
}
