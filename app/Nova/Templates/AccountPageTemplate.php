<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;

class AccountPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Account page";
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return $page->content;
    }
}
