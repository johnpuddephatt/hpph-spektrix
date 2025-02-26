<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Panel;

use Advoor\NovaEditorJs\NovaEditorJsField;
use Alexwenzel\DependencyContainer\DependencyContainer;
use Whitecube\NovaFlexibleContent\Flexible;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Ebess\AdvancedNovaMediaLibrary\Fields\Media;
use Eminiarts\Tabs\Traits\HasTabs;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Trix;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;

class Event extends Resource
{
    use HasTabs;

    public static $group = "Programme";

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Event::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = "name";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ["name"];

    public static $orderBy = ["first_instance_date_time" => "desc"];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScopes([
            "published",
            "enabled",
        ]);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make("Id")
                ->asBigInt()
                ->hide(),

            ID::make()
                ->sortable()
                ->readonly()->hideFromIndex(),

            Text::make("Live Spektrix API Data", "api_link", function () {
                return '<a class="link-default" href="' . $this->spektrix_api_link . '" target="_blank">View</a>';
            })
                ->asHtml()
                ->onlyOnDetail(),
            // Datetime::make("First Instance Date Time")->hide(),

            Text::make("Name")
                ->sortable()
                ->displayUsing(function ($name) {
                    return Str::limit($name, 26);
                })
                ->onlyOnIndex(),

            Text::make("Dates", "date_range", function () {
                return $this->instances->count() ? $this->date_range : "—";
            })
                ->asHtml()
                ->hideWhenUpdating(),

            Text::make("Instances", function ($model) {
                return $model->instances->count() ?: "—";
            })->onlyOnIndex(),

            Boolean::make("Published")
                ->showOnPreview()
                ->filterable(),

            Boolean::make("Programme?", "show_in_programme")
                ->showOnPreview()
                ->filterable(),

            Boolean::make("Synced", "enabled")
                ->readonly()
                ->showOnPreview()
                ->filterable(),


            // Tabs::make(
            //     "Tabs",
            //     [
            Panel::make("Overview", [
                Trix::make("Description")->rules([
                    Rule::requiredIf(fn() => $request->published),
                ]),
                NovaEditorJsField::make("Long description")->hideFromIndex(),
            ]),

            Panel::make("Media", [
                Media::make("Video")
                    ->conversionOnIndexView("thumb")
                    ->help("Maximum file size is 15MB")
                    // File size is set in config/media-library.php
                    ->singleMediaRules("max:15000"),
                Images::make("Image", "main")->rules([
                    Rule::requiredIf(fn() => $request->published),
                ]),
                Images::make("Image gallery", "gallery")
                    ->singleMediaRules("dimensions:min_width=800")
                    ->rules("max:4")
                    ->customPropertiesFields([Markdown::make("Description")])
                    ->fullWidth()
                    ->hideFromIndex()
                    ->help(
                        "Maximum four images, minimum width per image 800px"
                    ),
                Url::make("Trailer")
                    ->placeholder(
                        "Provide a URL for a video hosted on YouTube, Vimeo etc."
                    )
                    ->hideFromIndex(),
            ]),

            Panel::make("Related", [
                BelongsTo::make("Related event", "related_event", Event::class)
                    ->nullable()
                    ->searchable()
                    ->hideFromIndex(),
                Tag::make("Posts")
                    ->displayAsList()
                    ->hideFromIndex(),
            ]),

            Panel::make("Reviews", [
                Flexible::make("", "reviews")
                    ->addLayout("Review", "review", [
                        Select::make("Rating")->options([null, 1, 2, 3, 4, 5]),
                        Textarea::make("Quote"),
                        Text::make("Publication name"),
                        URL::make("URL"),
                    ])
                    ->fullWidth()
                    ->button("Add a review"),
            ]),

            Panel::make("Why watch?", [
                NovaSwitcher::make(
                    "Enabled?",
                    "why_watch->enabled"
                )->hideFromIndex(),
                DependencyContainer::make([
                    Textarea::make("Quote", "why_watch->quote")->rows(3),
                    Text::make("Name", "why_watch->name")->hideFromIndex(),
                    Text::make(
                        "Role/description",
                        "why_watch->role"
                    )->hideFromIndex(),
                ])->dependsOn("why_watch->enabled", 1),
            ]),

            Panel::make("Screenings", [
                HasMany::make("Screenings", "instances", "\App\Nova\Instance"),
            ]),

            Panel::make("Details", [
                // Boolean::make("Archive film")->onlyOnDetail(),
                Boolean::make("Audio description")->onlyOnDetail(),
                Boolean::make("MUBIGO")->onlyOnDetail(),
                Text::make("Coming soon")->onlyOnDetail(),
                // Boolean::make("Non-specialist film")->onlyOnDetail(),
                Text::make("Country of origin")->onlyOnDetail(),
                Text::make("Director")->onlyOnDetail(),
                Text::make("F-Rating", 'f_rating')->onlyOnDetail(),
                Text::make("Distributor")->onlyOnDetail(),
                Text::make("Genres")->onlyOnDetail(),
                Text::make("Vibes")->onlyOnDetail(),
                Text::make("Duration", "duration")->onlyOnDetail(),
                Text::make("Language")->onlyOnDetail(),
                Text::make("Original language title")->onlyOnDetail(),
                Text::make("Year of production")->onlyOnDetail(),
                Text::make("Featuring stars")->onlyOnDetail(),
                Text::make("Strobe light warning")->onlyOnDetail(),
            ]),

            URL::make(
                "URL",
                fn() => $this->slug ? $this->url : "#"
            )->displayUsing(fn() => $this->slug ? "Visit" : "–"),

            // Panel::make("Generated", [
            //     Text::make("Open graph image", "og_image", function () {
            //         return "<img src='" .
            //             og([
            //                 "title" => $this->name . "!",
            //                 "subtitle" => $this->date_range,
            //             ]) .
            //             "' />";
            //     })
            //         ->onlyOnDetail()
            //         ->asHtml(),
            // ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            Actions\FetchData::make()->standalone(),
            Actions\PublishEvents::make()->showInline(),
        ];
    }
}
