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
            new Panel("Featured films", [
                Multiselect::make("Films", "content->featured_films")
                    ->max(5)
                    ->reorderable()
                    ->asyncResource(Event::class)
                    ->saveAsJSON()
                    ->help(
                        "<style>.multiselect__tag { display: block; padding: 10px 20px 10px 5px !important; margin-bottom: 5px !important} .multiselect__tag-icon { line-height: 32px; } .multiselect__tag-icon:after { font-size: 20px;}</style>"
                    ),
            ]),
            new Panel("Our values", [
                Images::make(
                    "Image gallery",
                    "gallery"
                )->customPropertiesFields([
                    Select::make("Category")->options([
                        "Building",
                        "History",
                        "People",
                        "Redevelopment",
                    ]),
                ]),
                Text::make("Values heading", "content->values->heading"),
                Textarea::make(
                    "Values statement",
                    "content->values->statement"
                ),
                Text::make("Values link text", "content->values->link_text"),
                URL::make("Values link URL", "content->values->link_url"),
            ]),

            // new Panel("Banner", [
            //     NovaSwitcher::make("Enabled", "content->banner->enabled"),
            //     DependencyContainer::make([
            //         Text::make("Title", "content->banner->title"),
            //         Text::make("Subtitle", "content->banner->subtitle"),
            //         Text::make("URL", "content->banner->url"),
            //         Images::make("Image", "banner"),
            //     ])->dependsOn("content->banner->enabled", 1),
            // ]),

            // new Panel("Featured blog post", [
            //     Multiselect::make(
            //         "Tags to include",
            //         "content->featured_post_tags_to_include"
            //     )
            //         ->saveAsJSON()
            //         ->options(
            //             array_combine(
            //                 \Spatie\Tags\Tag::pluck("name")->toArray(),
            //                 \Spatie\Tags\Tag::pluck("name")->toArray()
            //             )
            //         )
            //         ->help(
            //             "Posts with any of the selected tags will be shown."
            //         ),
            // ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        if (!$page->content) {
            abort(404);
        }

        $shuffled_images = $page
            ->getMedia("gallery")
            ->shuffle()
            ->groupBy("custom_properties.category");

        return [
            "values" => [
                "heading" => $page->content->values->heading,
                "statement" => $page->content->values->statement,
                "images" => count($shuffled_images)
                    ? $shuffled_images
                        ->map(function ($values) {
                            return $values->first();
                        })
                        ->flatten()
                        ->filter(function ($item) {
                            return $item->hasGeneratedConversion("square");
                        })
                        ->map(function ($item) {
                            return [
                                "src" => $item->getUrl("square"),
                                "srcset" => $item->getSrcset("square"),
                            ];
                        })
                    : null,
                "link_text" => $page->content->values->link_text,
                "link_url" => $page->content->values->link_url,
            ],

            "events" => Cache::remember("home_events", 3600, function () use (
                $page
            ) {
                return (count($page->content->featured_films)
                    ? \App\Models\Event::whereIn(
                        "id",
                        $page->content->featured_films
                    )->orderByRaw(
                        "FIELD(id,'" .
                            implode("','", $page->content->featured_films) .
                            "')"
                    )
                    : \App\Models\Event::orderBy(
                        "first_instance_date_time",
                        "DESC"
                    )->take(3)
                )
                    ->with([
                        "instances.strand",
                        "featuredImage",
                        "featuredVideo",
                    ])
                    ->get()
                    ->each->append(["strands"])
                    ->map(function ($item, $key) {
                        return $item->formatForHomepage();
                    });
            }),

            "instances" => Cache::remember("home_instances", 3600, function () {
                return \App\Models\Instance::take(8)
                    ->with("event.featuredImage", "strand")
                    ->get()
                    ->map(function ($item) {
                        return [
                            "id" => $item->id,
                            "url" => $item->url,
                            "event" => [
                                "name" => $item->event->name,
                                "id" => $item->event->id,
                                "certificate_age_guidance" =>
                                    $item->event->certificate_age_guidance,
                            ],

                            "venue" => $item->venue,
                            "start_date" => $item->start_date,
                            "start_time" => $item->start_time,
                            "strand" => $item->strand,
                            "captioned" => $item->captioned,
                            "audio_described" => $item->audio_described,
                            "signed_bsl" => $item->signed_bsl,
                            "special_event" => $item->special_event,

                            "src" => $item->event->featuredImage
                                ? $item->event->featuredImage->getUrl("wide")
                                : null,
                            "srcset" => $item->event->featuredImage
                                ? $item->event->featuredImage->getSrcset("wide")
                                : null,
                        ];
                    });
            }),

            // "banner" => [
            //     "enabled" => $page->content->banner->enabled,
            //     "title" => $page->content->banner->title,
            //     "subtitle" => $page->content->banner->subtitle,
            //     "url" => $page->content->banner->url,
            //     "src" => $page->getMedia("banner")->count()
            //         ? $page->getMedia("banner")[0]->getUrl("landscape")
            //         : "",
            //     "srcset" => $page->getMedia("banner")->count()
            //         ? $page->getMedia("banner")[0]->getSrcset("landscape")
            //         : "",
            // ],
            "featured_posts" => Cache::remember(
                "home_featured_posts",
                3600,
                function () use ($page) {
                    return \App\Models\Post::latest()
                        ->where("featured", true)

                        ->take(1)
                        ->get()
                        ->map(function ($item) {
                            return [
                                "url" => $item->url,
                                "id" => $item->id,
                                "slug" => $item->slug,
                                "title" => $item->title,
                                "summary" => $item->summary,
                                "subtitle" => $item->subtitle,
                                "tags_translated" => $item->tagsTranslated,
                                "date" => $item->date,
                                "image" => $item->getImageSrc("wide"),
                            ];
                        });
                }
            ),

            "posts" => Cache::remember("home_posts", 3600, function () {
                return \App\Models\Post::latest()
                    ->with("featuredImage")
                    ->take(3)
                    ->whereNotIn(
                        "id",
                        Cache::get("home_featured_posts")
                            ? [Cache::get("home_featured_posts")[0]["id"]]
                            : null
                    )
                    ->get()
                    ->map(function ($item) {
                        return [
                            "url" => $item->url,
                            "slug" => $item->slug,
                            "title" => $item->title,
                            "summary" => $item->summary,
                            "subtitle" => $item->subtitle,
                            "tags_translated" => $item->tagsTranslated,
                            "date" => $item->date,
                            "image" => $item->getImageSrc("landscape"),
                        ];
                    });
            }),
        ];
    }

    // Optional suffix to the route (ie {blogPostName})
    public function pathSuffix(): string|null
    {
        return null;
    }
}
