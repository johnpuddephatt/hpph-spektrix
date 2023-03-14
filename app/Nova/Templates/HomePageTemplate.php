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
        // if (!$page->content) {
        //     abort(404);
        // }

        // $shuffled_images = $page
        //     ->getMedia("gallery")
        //     ->shuffle()
        //     ->groupBy("custom_properties.category");

        // return [
        //     "values" => [
        //         "heading" => $page->content->values->heading,
        //         "statement" => $page->content->values->statement,
        //         "images" => count($shuffled_images)
        //             ? $shuffled_images
        //                 ->map(function ($values) {
        //                     return $values->first();
        //                 })
        //                 ->flatten()
        //                 ->filter(function ($item) {
        //                     return $item->hasGeneratedConversion("square");
        //                 })
        //                 ->map(function ($item) {
        //                     return [
        //                         "src" => $item->getUrl("square"),
        //                         "srcset" => $item->getSrcset("square"),
        //                     ];
        //                 })
        //             : null,
        //         "link_text" => $page->content->values->link_text,
        //         "link_url" => $page->content->values->link_url,
        //     ],

        //     "events" => Cache::remember("home_events", 3600, function () use (
        //         $page
        //     ) {
        //         return (count($page->content->featured_films)
        //             ? \App\Models\Event::whereIn(
        //                 "id",
        //                 $page->content->featured_films
        //             )->orderByRaw(
        //                 "FIELD(id,'" .
        //                     implode("','", $page->content->featured_films) .
        //                     "')"
        //             )
        //             : \App\Models\Event::orderBy(
        //                 "first_instance_date_time",
        //                 "DESC"
        //             )->take(3)
        //         )
        //             ->with([
        //                 "instances.strand",
        //                 "featuredImage",
        //                 "featuredVideo",
        //             ])
        //             ->get()
        //             ->each->append(["strands"])
        //             ->map(function ($item, $key) {
        //                 return $item->formatForHomepage();
        //             });
        //     }),

        //     "instances" => Cache::remember("home_instances", 3600, function () {
        //         return \App\Models\Instance::take(8)
        //             ->with("event.featuredImage", "strand")
        //             ->get()
        //             ->map(function ($item) {
        //                 return [
        //                     "id" => $item->id,
        //                     "url" => $item->url,
        //                     "event" => [
        //                         "name" => $item->event->name,
        //                         "id" => $item->event->id,
        //                         "certificate_age_guidance" =>
        //                             $item->event->certificate_age_guidance,
        //                     ],

        //                     "venue" => $item->venue,
        //                     "start_date" => $item->start_date,
        //                     "start_time" => $item->start_time,
        //                     "strand" => $item->strand,
        //                     "captioned" => $item->captioned,
        //                     "audio_described" => $item->audio_described,
        //                     "signed_bsl" => $item->signed_bsl,
        //                     "special_event" => $item->special_event,

        //                     "src" => $item->event->featuredImage
        //                         ? $item->event->featuredImage->getUrl("wide")
        //                         : null,
        //                     "srcset" => $item->event->featuredImage
        //                         ? $item->event->featuredImage->getSrcset("wide")
        //                         : null,
        //                 ];
        //             });
        //     }),

        //     // "banner" => [
        //     //     "enabled" => $page->content->banner->enabled,
        //     //     "title" => $page->content->banner->title,
        //     //     "subtitle" => $page->content->banner->subtitle,
        //     //     "url" => $page->content->banner->url,
        //     //     "src" => $page->getMedia("banner")->count()
        //     //         ? $page->getMedia("banner")[0]->getUrl("landscape")
        //     //         : "",
        //     //     "srcset" => $page->getMedia("banner")->count()
        //     //         ? $page->getMedia("banner")[0]->getSrcset("landscape")
        //     //         : "",
        //     // ],
        //     "featured_posts" => Cache::remember(
        //         "home_featured_posts",
        //         3600,
        //         function () use ($page) {
        //             return \App\Models\Post::latest()
        //                 ->where("featured", true)

        //                 ->take(1)
        //                 ->get()
        //                 ->map(function ($item) {
        //                     return [
        //                         "url" => $item->url,
        //                         "id" => $item->id,
        //                         "slug" => $item->slug,
        //                         "title" => $item->title,
        //                         "summary" => $item->summary,
        //                         "subtitle" => $item->subtitle,
        //                         "tags_translated" => $item->tagsTranslated,
        //                         "date" => $item->date,
        //                         "image" => $item->getImageSrc("wide"),
        //                     ];
        //                 });
        //         }
        //     ),

        //     "posts" => Cache::remember("home_posts", 3600, function () {
        //         return \App\Models\Post::latest()
        //             ->with("featuredImage")
        //             ->take(3)
        //             ->whereNotIn(
        //                 "id",
        //                 Cache::get("home_featured_posts")
        //                     ? [Cache::get("home_featured_posts")[0]["id"]]
        //                     : null
        //             )
        //             ->get()
        //             ->map(function ($item) {
        //                 return [
        //                     "url" => $item->url,
        //                     "slug" => $item->slug,
        //                     "title" => $item->title,
        //                     "summary" => $item->summary,
        //                     "subtitle" => $item->subtitle,
        //                     "tags_translated" => $item->tagsTranslated,
        //                     "date" => $item->date,
        //                     "image" => $item->getImageSrc("landscape"),
        //                 ];
        //             });
        //     }),
        // ];
    }

    // Optional suffix to the route (ie {blogPostName})
    public function pathSuffix(): string|null
    {
        return null;
    }
}
