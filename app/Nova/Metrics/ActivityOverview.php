<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;
use Illuminate\Support\Facades\Blade;

class ActivityOverview extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $rows = [];
        foreach (
            \Spatie\Activitylog\Models\Activity::latest()
                ->limit(3)
                ->get()
            as $activity
        ) {
            $rows[] = MetricTableRow::make()
                ->icon(
                    match ($activity->description) {
                        "created" => "star",
                        "updated" => "pencil-alt",
                        default => "info",
                    }
                )
                ->iconClass("text-sky-500")
                ->title(
                    Blade::render(
                        '{{$activity->causer->name}} {{$activity->description}} {!!$activity->getExtraProperty("attributes.title") ?? $activity->getExtraProperty("attributes.name")!!}',
                        compact("activity")
                    )
                )
                ->subtitle(
                    Blade::render(
                        'in {{ class_basename($activity->subject_type) }}s – {{ $activity->created_at->diffForHumans() }}',
                        compact("activity")
                    )
                );
        }
        return $rows;
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(1);
    }
}
