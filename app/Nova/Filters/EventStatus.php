<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Events drop out of the Spektrix feed for two quite different reasons, and
 * `enabled = false` alone can't tell them apart:
 *
 *  - the event finished, so it falls outside the import's `instanceStart_from`
 *    window (FetchEventData::getEvents) — the overwhelmingly common case;
 *  - the event was deleted or disabled in Spektrix while it still had dates in
 *    the diary — rare, and worth looking at, because the event may still be
 *    published on the public site with screenings that no longer exist.
 *
 * Lumping those together under "missing from the latest import" is misleading,
 * so they get separate options here. `last_instance_date_time` is what
 * distinguishes them.
 */
class EventStatus extends Filter
{
    public $component = "select-filter";

    public $name = "Status";

    public function apply(NovaRequest $request, $query, $value)
    {
        return match ($value) {
            "current" => $query->where("enabled", true),
            "finished" => $query
                ->where("enabled", false)
                ->where("last_instance_date_time", "<", now()),
            "withdrawn" => $query
                ->where("enabled", false)
                ->where(fn(Builder $q) => $q
                    ->where("last_instance_date_time", ">=", now())
                    ->orWhereNull("last_instance_date_time")),
            default => $query,
        };
    }

    public function options(NovaRequest $request)
    {
        return [
            "Current and upcoming" => "current",
            "Finished" => "finished",
            "Withdrawn from Spektrix" => "withdrawn",
            "Everything" => "all",
        ];
    }

    /**
     * Past events are rarely edited, so the listing opens on what's live.
     */
    public function default()
    {
        return "current";
    }
}
