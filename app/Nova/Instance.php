<?php

namespace App\Nova;

use App\Nova\Filters\ScreeningDate;
use App\Nova\Filters\SyncStatus;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\DateTime;

class Instance extends Resource
{
    public static $group = "Programme";

    public static $displayInNavigation = false;

    public static function searchable()
    {
        return false;
    }

    public static function label()
    {
        return "Screenings";
    }

    /**
     * Nova falls back to ordering by primary key, and these are opaque Spektrix
     * IDs, so without this the listing looks unordered.
     */
    public static $orderBy = ["start" => "asc"];

    /**
     * Every row renders its event, seasons and strands, which is three queries
     * per row without this.
     */
    public static $with = ["event", "seasons", "strands"];

    /**
     * Admin needs to see screenings the public listings deliberately hide:
     * cancelled ones (otherwise the Cancelled column is always false), past ones
     * and those belonging to coming-soon events. The `future` scope is put back
     * by the ScreeningDate filter's default, so the listing still opens on
     * upcoming screenings only.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScopes([
            "enabled",
            "future",
            "not_cancelled",
            "not_coming_soon",
        ]);
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
            BelongsTo::make("Event"),
            ID::make()
                ->sortable()
                ->readonly()->hideFromIndex(),

            Text::make("Live Spektrix API Data", "api_link", function () {
                return '<a class="link-default" href="' . $this->spektrix_api_link . '" target="_blank">Instance data</a> / ' .
                    '<a class="link-default" href="' . $this->spektrix_api_link . '/status?includeLockInformation=true&includeChildPlans=true" target="_blank">Status data</a>';
            })
                ->asHtml()
                ->onlyOnDetail(),

            DateTime::make("Start")->sortable(),
            Boolean::make("On sale", "is_on_sale"),
            Boolean::make("Cancelled"),
            Boolean::make("Synced", "enabled"),

            // Boolean::make("Short film with feature")->onlyOnDetail(),

            // Boolean::make("AD", "audio_described"),
            Boolean::make("Captioned"),
            Boolean::make("Relaxed", "relaxed"),
            Boolean::make("BSL", "signed_bsl"),
            Boolean::make("Autism-friendly", "autism_friendly"),
            Boolean::make("Toddler-friendly", "toddler_friendly"),

            Text::make("Special", "special_event"),

            Text::make("Analogue")->onlyOnDetail(),
            Text::make("Door time")->onlyOnDetail(),
            Text::make("Partnership")->onlyOnDetail(),
            Text::make("External ticket link")->onlyOnDetail(),

            Text::make("Seasons", fn() => $this->seasons->pluck("name")->join(", "))->exceptOnForms(),
            Text::make("Strands", fn() => $this->strands->pluck("name")->join(", "))->exceptOnForms(),
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
        return [new ScreeningDate(), new SyncStatus(defaultValue: "all")];
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
