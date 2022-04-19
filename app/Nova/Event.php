<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Panel;
use Advoor\NovaEditorJs\NovaEditorJs;

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
                ->asBigInt()
                ->sortable()
                ->onlyOnIndex(),

            Text::make("Name")->showOnPreview(),
            NovaEditorJs::make("Content")->hideFromIndex(),
            HasMany::make("Screenings", "instances", "\App\Nova\Instance"),
            new Panel("Dates", $this->dateFields()),
            (new Panel("Details", $this->additionalFields()))->limit(4),
        ];
    }

    protected function dateFields()
    {
        return [
            Text::make("Dates", "instance_dates")->hideWhenUpdating(),
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
            Text::make("Distributor")->onlyOnDetail(),
            Text::make("F-Rating")->onlyOnDetail(),
            Text::make("Distributor")->onlyOnDetail(),
            Text::make("Language")->onlyOnDetail(),
            Text::make("Distributor")->onlyOnDetail(),
            Text::make("Original language title")->onlyOnDetail(),
            BelongsTo::make("Strand")->exceptOnForms(),
            Text::make("Year of production")->onlyOnDetail(),
            Text::make("Featuring", function ($model) {
                $featuring = [];
                $featuring[] = $model->featuring_stars_1 ?? null;
                $featuring[] = $model->featuring_stars_2 ?? null;
                $featuring[] = $model->featuring_stars_3 ?? null;
                return implode(", ", $featuring);
            })->onlyOnDetail(),
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
        return [Actions\FetchData::make()->standalone()];
    }
}
