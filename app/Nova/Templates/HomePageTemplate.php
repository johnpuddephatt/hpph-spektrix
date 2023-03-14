<?php

namespace App\Nova\Templates;

use App\Nova\Event;
use Illuminate\Http\Request;
use Laravel\Nova\Panel;

use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Outl1ne\MultiselectField\Multiselect;
// use Whitecube\NovaFlexibleContent\Flexible;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Alexwenzel\DependencyContainer\DependencyContainer;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\FormData;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\URL;
use Whitecube\NovaFlexibleContent\Flexible;

class HomePageTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return "Home page";
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel("Content", [
                Flexible::make("Content", "content")
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\HomeHeroLayout::class
                    )
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\HomeCarouselLayout::class
                    )
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\HomeInstancesLayout::class
                    )
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\JournalPostLayout::class
                    )
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\JournalPostsLayout::class
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
    public function pathSuffix(): string|null
    {
        return null;
    }
}
