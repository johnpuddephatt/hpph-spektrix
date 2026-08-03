<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Filters imported resources by whether they appeared in the most recent
 * Spektrix import. Defaults to hiding the ones that didn't, which is what keeps
 * listings such as Seasons down to the records editors still care about.
 */
class SyncStatus extends Filter
{
    public $component = "select-filter";

    public $name = "Spektrix sync";

    /**
     * @param  bool  $forceable  Whether the model has a `force_enabled_until`
     *                           column that can keep a record live regardless
     *                           of the last import.
     * @param  string  $defaultValue  Pass "all" on resources where records
     *                                routinely and legitimately drop out of the
     *                                import, such as past events.
     */
    public function __construct(
        protected bool $forceable = false,
        protected string $defaultValue = "synced"
    ) {
    }

    public function apply(NovaRequest $request, $query, $value)
    {
        return match ($value) {
            "synced" => $query->where(fn(Builder $q) => $this->synced($q)),
            "unsynced" => $query->whereNot(fn(Builder $q) => $this->synced($q)),
            default => $query,
        };
    }

    protected function synced(Builder $query): Builder
    {
        $query->where("enabled", true);

        if ($this->forceable) {
            $query->orWhere("force_enabled_until", ">=", now());
        }

        return $query;
    }

    public function options(NovaRequest $request)
    {
        return [
            "In the latest import" => "synced",
            "Missing from the latest import" => "unsynced",
            "Everything" => "all",
        ];
    }

    public function default()
    {
        return $this->defaultValue;
    }
}
