<?php

namespace App\Nova\Concerns;

use Carbon\Carbon;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

/**
 * Index columns derived from the `allInstances` aggregates. Resources ordered by
 * their most recent screening need these on the index, otherwise the ordering
 * has nothing visible to justify it.
 */
trait ShowsScreeningDates
{
    /**
     * Aggregate the attached screenings onto the query. Uses `allInstances` so
     * past and cancelled screenings count — a season that finished last year
     * should still sort by when it ran.
     */
    protected static function withScreeningAggregates($query)
    {
        return $query
            ->withMin("allInstances as first_screening", "start")
            ->withMax("allInstances as latest_screening", "start")
            ->withCount("allInstances as screenings_count");
    }

    protected function screeningDateFields(): array
    {
        return [
            Text::make("Dates", function ($model) {
                if (!$model->first_screening) {
                    return "—";
                }

                $first = Carbon::parse($model->first_screening);
                $last = Carbon::parse($model->latest_screening);

                return $first->isSameDay($last)
                    ? $first->format("j M Y")
                    : $first->format("j M Y") . " – " . $last->format("j M Y");
            })->onlyOnIndex(),

            Number::make("Screenings", "screenings_count")->onlyOnIndex(),
        ];
    }
}
