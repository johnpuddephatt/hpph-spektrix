<?php

namespace App\Nova\Metrics;

use Illuminate\Support\Facades\Blade;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityOverview extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $rows = [];
        foreach (
            Activity::latest()
                ->limit(3)
                ->get() as $activity
        ) {
            $rows[] = MetricTableRow::make()
                ->icon(
                    match ($activity->description) {
                        'restored' => 'refresh',
                        'deleted' => 'trash',
                        'created' => 'star',
                        'updated' => 'pencil-alt',
                        default => 'info',
                    }
                )
                ->iconClass('text-sky-500')
                ->title(
                    Blade::render(
                        '{{$activity->causer ? $activity->causer->name : "System" }} {{$activity->description}} {!! ($activity->getExtraProperty("attributes.title") ?? $activity->getExtraProperty("attributes.name")) ?? ($activity->getExtraProperty("old.title") ?? $activity->getExtraProperty("old.name")) !!}',
                        compact('activity')
                    )
                )
                ->subtitle(
                    Blade::render(
                        'in {{ class_basename($activity->subject_type) }}s – {{ $activity->created_at->diffForHumans() }}',
                        compact('activity')
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
