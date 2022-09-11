<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Template;
use Laravel\Nova\Panel;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;

class JobsPageTemplate
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
            new Panel("Header gallery", [
                Images::make("Image gallery", "gallery"),
                // ->customPropertiesFields([Text::make("Label")]),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page, $params): array
    {
        // Modify data as you please (ie turn ID-s into models)
        return $page->data;
    }

    // Optional suffix to the route (ie {blogPostName})
    public function pathSuffix(): string|null
    {
        return null;
    }
}
