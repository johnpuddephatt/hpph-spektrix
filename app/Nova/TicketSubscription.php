<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use NormanHuth\Values\Values;

class TicketSubscription extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\TicketSubscription::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ['id', 'name'];

    public static function label()
    {
        return 'Ticket subscriptions';
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScope('enabled');
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
            ID::make()->hide(),

            Text::make('Name')
                ->readonly()
                ->help(
                    'Set in Spektrix. Renaming a subscription there creates a new
                    entry here and disables this one, so the content below would
                    need adding to the new entry.'
                ),

            // Backed by a real attribute rather than a closure: a closure would
            // make this a computed field, and Nova drops computed fields from
            // create/update forms — so it would vanish from the screen editors
            // actually work on. fillUsing is a no-op because the accessor has no
            // matching column to write back to.
            Text::make('Prices', 'pricing_set_summary')
                ->readonly()
                ->fillUsing(fn () => null)
                ->help('The price options set up in Spektrix.'),

            DateTime::make('On sale', 'on_sale_at')->readonly()->hideFromIndex(),
            DateTime::make('Off sale', 'off_sale_at')->readonly()->hideFromIndex(),

            // Where the pass is sold. A strand or season page renders whichever
            // pass points at it, between its description and its what's on
            // slider, so this field is the whole of the wiring.
            //
            // Polymorphic rather than a pair of strand/season selects: there is
            // one thing to fill in, and no way to fill in both.
            MorphTo::make('Shown on', 'subject')
                ->types([Strand::class, Season::class])
                ->nullable()
                ->searchable()
                ->help(
                    'The strand or season this pass is sold with. It appears on that
                    page, under the description. One pass per strand or season.'
                ),

            Panel::make('Details', [
                Textarea::make('Description')->help(
                    "Shown under the subscription name. Spektrix's own description
                    is not used on the website."
                ),
                Values::make('Benefits')->valueLabel('Benefit'),
                Textarea::make('Terms')->hideFromIndex(),
            ]),

            Boolean::make('Synced', 'enabled')
                ->readonly()
                ->showOnPreview()
                ->filterable(),
        ];
    }

    /**
     * Rows come from Spektrix, so they cannot be hand-created.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return bool
     */
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
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
        return [new \App\Nova\Filters\SyncStatus()];
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
