<?php

namespace App\Nova\Templates;

use App\Nova\Flexible\Layouts\FilmLayout;
use Illuminate\Http\Request;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class Error404PageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return '404 page';
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel('Page content', [
                Flexible::make('Content', 'content')
                    ->addLayout(FilmLayout::class)
                    ->button('Add new film')
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
