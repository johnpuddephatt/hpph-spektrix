<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Panel;

use Advoor\NovaEditorJs\NovaEditorJsField;

use Outl1ne\NovaSimpleRepeatable\SimpleRepeatable;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;

class Event extends Resource
{
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

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScopes();
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
                ->hideFromIndex(),

            Boolean::make("Published")
                ->showOnPreview()
                ->filterable(),

            Text::make("Name")
                ->sortable()
                ->hideWhenUpdating(),

            NovaEditorJsField::make("Long description")->hideFromIndex(),

            Images::make("Main image", "main"),
            // ->conversionOnIndexView("thumb")

            Images::make("Image gallery", "gallery")

                // ->conversionOnPreview("medium-size")
                // ->conversionOnDetailView("thumb")
                // ->conversionOnIndexView("thumb")
                // ->conversionOnForm("thumb")
                // ->fullSize()
                // ->rules("required", "size:3")
                ->singleImageRules("dimensions:min_width=100")
                ->customPropertiesFields([
                    Boolean::make("Active"),
                    Markdown::make("Description"),
                ]),

            SimpleRepeatable::make("Reviews", "reviews", [
                Text::make("Rating"),
                Textarea::make("Quote"),
                Text::make("Publication name"),
                Text::make("URL"),
            ])->addRowLabel("Add a review"),

            HasMany::make("Screenings", "instances", "\App\Nova\Instance"),
            new Panel("Dates", $this->dateFields()),
            (new Panel("Details", $this->additionalFields()))->limit(4),
            Text::make("Instances", function ($model) {
                return $model->instances->count();
            })->onlyOnIndex(),
        ];
    }

    protected function dateFields()
    {
        return [
            Text::make("Dates", function ($model) {
                return $model->dateRange;
            })->hideWhenUpdating(),
            Text::make("Duration (minutes)", "duration")->onlyOnDetail(),
            Text::make("First instance date time")->onlyOnDetail(),
            Text::make("Last instance date time")->onlyOnDetail(),
        ];
    }
    protected function additionalFields()
    {
        return [
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

            Text::make("Language")->onlyOnDetail(),
            Text::make("Original language title")->onlyOnDetail(),
            Text::make("Year of production")->onlyOnDetail(),
            Text::make("Featuring stars")->onlyOnDetail(),
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
            Actions\PublishEvents::make(),
        ];
    }
}
