<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Panel;

use Advoor\NovaEditorJs\NovaEditorJsField;

use Whitecube\NovaFlexibleContent\Flexible;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Eminiarts\Tabs\Traits\HasTabs;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\Tab;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Trix;

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
        return $query->withoutGlobalScopes(["published", "enabled"]);
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

            // Datetime::make("First Instance Date Time")->hide(),

            Text::make("Name")
                ->sortable()
                ->displayUsing(function ($name) {
                    return Str::limit($name, 26);
                })
                ->onlyOnIndex(),

            Text::make("Instance dates")->hideWhenUpdating(),

            Boolean::make("Published")
                ->showOnPreview()
                ->filterable(),

            Boolean::make("Synced", "enabled")
                ->readonly()
                ->showOnPreview()
                ->filterable(),

            Tabs::make(
                "Tabs",
                [
                    Tab::make("Overview", [
                        Trix::make("Description")
                            ->required()
                            ->rules("required"),
                        NovaEditorJsField::make(
                            "Long description"
                        )->hideFromIndex(),

                        // SimpleRepeatable::make("Reviews", "reviews", [
                        //     Text::make("Rating"),
                        //     Textarea::make("Quote"),
                        //     Text::make("Publication name"),
                        //     Text::make("URL"),
                        // ])
                        //     ->addRowLabel("Add a review")
                        //     ->stacked(),
                    ]),
                    Tab::make("Reviews", [
                        Flexible::make("Reviews")
                            ->addLayout("Review", "review", [
                                Select::make("Rating")->options([
                                    1,
                                    2,
                                    3,
                                    4,
                                    5,
                                ]),
                                Textarea::make("Quote"),
                                Text::make("Publication name"),
                                URL::make("URL"),
                            ])
                            ->button("Add a review")
                            ->stacked(),
                    ]),
                    Tab::make("Media", [
                        Images::make("Main image", "main")
                            ->required()
                            ->rules("required"),
                        Images::make(
                            "Secondary image",
                            "secondary"
                        )->hideFromIndex(),
                        Images::make("Image gallery", "gallery")
                            ->singleImageRules("dimensions:min_width=100")
                            ->customPropertiesFields([
                                Markdown::make("Description"),
                            ])
                            ->hideFromIndex(),
                        // ->conversionOnPreview("medium-size")
                        // ->conversionOnDetailView("thumb")
                        // ->conversionOnIndexView("thumb")
                        // ->conversionOnForm("thumb")
                        // ->fullSize()
                        // ->rules("required", "size:3")
                    ]),
                ],
                false
            ),

            Panel::make("Screenings", [
                HasMany::make("Screenings", "instances", "\App\Nova\Instance"),
            ]),

            Panel::make("Details", [
                // Text::make("First instance date time")->onlyOnDetail(),
                // Text::make("Last instance date time")->onlyOnDetail(),
                Boolean::make("Archive film")->onlyOnDetail(),
                Boolean::make("Audio description")->onlyOnDetail(),
                Boolean::make("MUBIGO")->onlyOnDetail(),
                Boolean::make("Non-specialist film")->onlyOnDetail(),
                Text::make("Country of origin")->onlyOnDetail(),
                Text::make("Director")->onlyOnDetail(),
                Text::make("F-Rating")->onlyOnDetail(),
                Text::make("Distributor")->onlyOnDetail(),
                Text::make("Genres")->onlyOnDetail(),
                Text::make("Vibes")->onlyOnDetail(),
                Text::make("Duration (minutes)", "duration")->onlyOnDetail(),
                Text::make("Language")->onlyOnDetail(),
                Text::make("Original language title")->onlyOnDetail(),
                Text::make("Year of production")->onlyOnDetail(),
                Text::make("Featuring stars")->onlyOnDetail(),
            ]),

            // new Panel("Dates", $this->dateFields()),
            // (new Panel("Details", $this->additionalFields()))->limit(4),

            Text::make("Instances", function ($model) {
                return $model->instances->count();
            })->onlyOnIndex(),

            URL::make(
                "URL",
                fn() => $this->slug ? $this->url : "#"
            )->displayUsing(fn() => $this->slug ? "View" : "–"),
        ];
    }

    // protected function dateFields()
    // {
    //     return
    // }
    // protected function additionalFields()
    // {
    //     return [

    //     ];
    // }

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
