<?php

namespace App\Nova\Templates;

use App\Nova\Flexible\Layouts\SectionLayout;
use Illuminate\Http\Request;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class SectionedPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return 'Sectioned page';
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel('Page content', [
                Flexible::make('Content', 'content')
                    ->addLayout(SectionLayout::class)
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
