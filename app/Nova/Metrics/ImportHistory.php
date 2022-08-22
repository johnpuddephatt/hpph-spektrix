<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;
use Stepanenko3\LogsTool\LogsService;

class ImportHistory extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $logs = array_slice(LogsService::all("laravel-spektrix.log"), 0, 3);
        if ($logs) {
            foreach ($logs as $log) {
                $rows[] = MetricTableRow::make()
                    ->icon(
                        $log["level"] == "info"
                            ? "check-circle"
                            : $log["level_img"]
                    )
                    ->iconClass(
                        $log["level"] == "info"
                            ? "text-green-500"
                            : $log["level_class"]
                    )
                    ->title($log["text"])
                    ->subtitle(
                        \Carbon\Carbon::create($log["date"])->diffForHumans()
                    );
            }
        } else {
            $rows[] = MetricTableRow::make()
                ->icon("information-circle")
                ->iconClass("text-primary-500")
                ->title("Log empty")
                ->subtitle("No log entries were found.");
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
        // return now()->addMinutes(5);
    }
}
