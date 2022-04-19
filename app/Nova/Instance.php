<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class Instance extends Resource
{
    public static $group = "Programme";

    public static $displayInNavigation = false;

    public static function label()
    {
        return "Screenings";
    }
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Instance::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = "start";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ["start"];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()
                ->sortable()
                ->hideFromIndex(),
            Text::make("Start"),
            Boolean::make("Is on sale"),
            Boolean::make("Cancelled"),
            Text::make("Analogue"),
            Boolean::make("Captioned"),
            Text::make("Special event"),
            Boolean::make("Short film with feature")->onlyOnDetail(),
            Boolean::make("Audio described"),
            BelongsTo::make("Season")->exceptOnForms(),
            Text::make("Target audience")->hideFromIndex(),
            Text::make("Target audience_2")->hideFromIndex(),
            Boolean::make("Signed BSL"),
            Boolean::make("Relaxed", "relaxed_performance"),
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
        return [];
    }
}
