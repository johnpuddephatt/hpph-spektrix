<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;
use Laravel\Nova\Menu\MenuItem;

class SpektrixOverview extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return [
            MetricTableRow::make()
                ->icon("information-circle")
                ->iconClass("text-sky-500")
                ->title(\App\Models\Event::count() . " events")
                ->actions(function () {
                    return [
                        MenuItem::externalLink(
                            "View all",
                            route("nova.pages.index", ["resource" => "events"])
                        ),
                    ];
                }),
            // ->subtitle('In every part of the globe it is the same!'),
            MetricTableRow::make()
                ->icon("information-circle")
                ->iconClass("text-sky-500")
                ->title(\App\Models\Instance::count() . " instances"),

            // ->subtitle('In every part of the globe it is the same!'),
            MetricTableRow::make()
                ->icon("information-circle")
                ->iconClass("text-sky-500")
                ->title(\App\Models\Membership::count() . " memberships")
                ->actions(function () {
                    return [
                        MenuItem::externalLink(
                            "View all",
                            route("nova.pages.index", [
                                "resource" => "memberships",
                            ])
                        ),
                    ];
                }),
            // ->subtitle('In every part of the globe it is the same!'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }
}
