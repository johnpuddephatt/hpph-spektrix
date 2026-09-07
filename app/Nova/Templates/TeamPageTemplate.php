<?php

namespace App\Nova\Templates;

use App\Models\User;
use Illuminate\Http\Request;

class TeamPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return 'Team page';
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return array_merge((array) $page->content, [
            'users' => User::where(
                'show_in_directory',
                true
            )->get(),
        ]);
    }
}
