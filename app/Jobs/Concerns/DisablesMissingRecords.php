<?php

namespace App\Jobs\Concerns;

use App\Cache\ContentCache;

trait DisablesMissingRecords
{
    /**
     * Disable only the rows Spektrix has stopped sending.
     *
     * Deliberately not the old "disable everything, then re-enable what came back"
     * pass: that dirtied every row on every run, and each dirty row cleared the
     * whole cache through the observers. This way an unchanged import writes
     * nothing and clears nothing.
     *
     * A mass update() fires no model events, so the clear is requested explicitly
     * here — and only when a row actually changed.
     *
     * @param  class-string  $model
     * @param  array  $keys  the keys present in this import
     * @param  string  $column  the column those keys match on
     */
    protected function disableMissing(string $model, array $keys, string $column = 'id'): void
    {
        $disabled = $model::withoutGlobalScopes()
            ->where('enabled', true)
            ->when($keys !== [], fn ($query) => $query->whereNotIn($column, $keys))
            ->update(['enabled' => false]);

        if ($disabled) {
            ContentCache::clear();
        }
    }
}
