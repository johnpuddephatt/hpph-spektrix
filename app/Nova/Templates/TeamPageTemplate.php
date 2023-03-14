<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Template;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Panel;

class TeamPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Team page";
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
            "users" => \App\Models\User::where(
                "show_in_directory",
                true
            )->get(),
        ]);
    }
}
