<?php

namespace App\Nova\Metrics;

use App\Models\Event;
use App\Models\Fund;
use App\Models\Instance;
use App\Models\Membership;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class SpektrixOverview extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return [
            MetricTableRow::make()
                ->icon('information-circle')
                ->iconClass('text-sky-500')
                ->title(Event::count().' events')
                ->actions(function () {
                    return [
                        MenuItem::resource(\App\Nova\Event::class)->name(
                            'Go to events'
                        ),
                    ];
                })
                ->subtitle(Instance::count().' instances'),

            MetricTableRow::make()
                ->icon('information-circle')
                ->iconClass('text-sky-500')
                ->title(Membership::count().' memberships')
                ->actions(function () {
                    return [
                        MenuItem::resource(\App\Nova\Membership::class)->name(
                            'Go to memberships'
                        ),
                    ];
                }),
            MetricTableRow::make()
                ->icon('information-circle')
                ->iconClass('text-sky-500')
                ->title(Fund::count().' funds')
                ->actions(function () {
                    return [
                        MenuItem::resource(\App\Nova\Fund::class)->name(
                            'Go to funds'
                        ),
                    ];
                }),
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
