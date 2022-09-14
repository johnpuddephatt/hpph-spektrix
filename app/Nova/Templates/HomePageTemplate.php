<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Laravel\Nova\Panel;

use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Outl1ne\MultiselectField\Multiselect;
// use Whitecube\NovaFlexibleContent\Flexible;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;

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
            new Panel("Our values", [
                Images::make("Image gallery", "gallery"),
                // ->customPropertiesFields([Text::make("Label")]),
                Text::make("Values statement", "content->values_statement"),
            ]),

            new Panel("Banner", [
                Text::make("Title", "content->banner->title"),
                Text::make("Subtitle", "content->banner->subtitle"),
                Text::make("URL", "content->banner->url"),
                Select::make("Height", "content->banner->height")
                    ->options([
                        null => "Auto",
                        "min-h-[66vh]" => "Two-thirds",
                        "min-h-screen" => "Full",
                    ])
                    ->displayUsingLabels(),
                Images::make("Image", "banner"),
                Boolean::make("Overlay", "content->banner->overlay"),
                Select::make("Text colour", "content->banner->text_color")
                    ->options([
                        "text-black" => "Black",
                        "text-white" => "White",
                    ])
                    ->displayUsingLabels(),
                Select::make("Background colour", "content->banner->bg_color")
                    ->options([
                        "bg-black" => "Black",
                        "bg-white" => "White",
                        "bg-yellow" => "Yellow",
                    ])
                    ->displayUsingLabels(),
            ]),

            new Panel("Featured blog posts", [
                Number::make(
                    "Number of posts",
                    "content->featured_post_number_of_posts"
                ),
                Multiselect::make(
                    "Tags to include",
                    "content->featured_post_tags_to_include"
                )
                    ->saveAsJSON()
                    ->options(
                        array_combine(
                            \Spatie\Tags\Tag::pluck("name")->toArray(),
                            \Spatie\Tags\Tag::pluck("name")->toArray()
                        )
                    )
                    ->help(
                        "Posts with any of the selected tags will be shown."
                    ),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page): array
    {
        return [
            "values_statement" => $page->content->values_statement,
            "values_images" => $page
                ->getMedia("gallery")
                ->shuffle()
                ->take(5)
                ->map(function ($item) {
                    return [
                        "src" => $item->getUrl("portrait"),
                        "srcset" => $item->getSrcset("portrait"),
                    ];
                }),
            "instance_options" => $this->getInstanceOptions(),
            "posts" => Cache::remember("home_posts", 3600, function () {
                return \App\Models\Post::with("featuredImage")
                    ->latest()
                    ->take(3)
                    ->get()
                    ->map(function ($item) {
                        return [
                            "slug" => $item->slug,
                            "title" => $item->title,
                            "created_at" => $item->created_at->format("d M"),
                            "src" => $item->featuredImage
                                ? $item->featuredImage->getUrl("landscape")
                                : null,
                            "srcset" => $item->featuredImage
                                ? $item->featuredImage->getSrcset("landscape")
                                : null,
                        ];
                    });
            }),
            "events" => Cache::remember("home_events", 3600, function () {
                return \App\Models\Event::with("featuredImage")
                    ->take(4)
                    ->get()
                    ->each->append("strands")
                    ->map(function ($item, $key) {
                        return [
                            "name" => $item->name,
                            "slug" => $item->slug,
                            "certificate_age_guidance" =>
                                $item->certificate_age_guidance,
                            "src" => $item->featuredImage
                                ? $item->featuredImage->getUrl("square")
                                : null,
                            "srcset" => $item->featuredImage
                                ? $item->featuredImage->getSrcset("square")
                                : null,
                            "strands" => $item->strands,
                        ];
                    });
            }),
            "banner" => [
                "title" => $page->content->banner->title,
                "subtitle" => $page->content->banner->subtitle,
                "height" => $page->content->banner->height,
                "url" => $page->content->banner->url,
                "src" => $page->getMedia("banner")->count()
                    ? $page->getMedia("banner")[0]->getUrl("landscape")
                    : "",
                "srcset" => $page->getMedia("banner")->count()
                    ? $page->getMedia("banner")[0]->getSrcset("landscape")
                    : "",
                "overlay" => $page->content->banner->overlay,
                "bg_color" => $page->content->banner->bg_color,
                "text_color" => $page->content->banner->text_color,
            ],
            "featured_posts" => Cache::remember(
                "home_featured_posts",
                3600,
                function () use ($page) {
                    return \App\Models\Post::latest()
                        ->withAnyTags(
                            $page->content->featured_post_tags_to_include ?? []
                        )
                        ->take(
                            $page->content->featured_post_number_of_posts ?? 1
                        )
                        ->get()
                        ->map(function ($item) {
                            return [
                                "slug" => $item->slug,
                                "title" => $item->title,
                                "introduction" => $item->introduction,
                                "created_at" => $item->created_at->format(
                                    "d M"
                                ),
                                "image" => $item->featuredImage
                                    ? $item->featuredImage
                                        ->img("landscape", [
                                            "class" => "w-3/4 lg:w-1/2 rounded",
                                        ])
                                        ->toHtml()
                                    : null,
                            ];
                        });
                }
            ),
        ];
    }

    // Optional suffix to the route (ie {blogPostName})
    public function pathSuffix(): string|null
    {
        return null;
    }

    public function getInstanceOptions()
    {
        if (
            \App\Models\Instance::today()->count() &&
            \App\Models\Instance::tomorrow()->count()
        ) {
            return [
                ["label" => "Today", "offset" => 0, "duration" => 1],
                ["label" => "Tomorrow", "offset" => 1, "duration" => 1],
            ];
        } elseif (\App\Models\Instance::today()->count()) {
            return [["label" => "Today", "offset" => 0, "duration" => 1]];
        } elseif (\App\Models\Instance::tomorrow()->count()) {
            return [["label" => "Tomorrow", "offset" => 1, "duration" => 1]];
        } else {
            return [
                [
                    "label" => "Soon",
                    "offset" => 0,
                    "duration" => 28,
                    "limit" => 6,
                ],
            ];
        }
    }
}
