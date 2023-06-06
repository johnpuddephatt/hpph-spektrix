<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Panel;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\MultiSelect;
use Whitecube\NovaFlexibleContent\Flexible;

class JournalPageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Journal page";
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
        // return array_merge((array) $page->content, [
        //     "featured_post" => \App\Models\Post::latest()
        //         ->where("featured", true)
        //         ->with("tagsTranslated")
        //         ->first(),
        // ]);
    }
}
