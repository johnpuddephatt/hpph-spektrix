<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * The Screenings index removes the `future` global scope so past screenings are
 * reachable at all; this puts the upcoming-only view back as the default.
 */
class ScreeningDate extends Filter
{
    public $component = "select-filter";

    public $name = "Date";

    public function apply(NovaRequest $request, $query, $value)
    {
        return match ($value) {
            "upcoming" => $query->where("start", ">", now()->subHour()),
            "past" => $query->where("start", "<=", now()->subHour()),
            default => $query,
        };
    }

    public function options(NovaRequest $request)
    {
        return [
            "Upcoming" => "upcoming",
            "Past" => "past",
            "All" => "all",
        ];
    }

    public function default()
    {
        return "upcoming";
    }
}
