<?php

namespace App\Observers;

use App\Cache\ContentCache;

/**
 * Clears cached content when a watched model actually changes.
 *
 * Note there is deliberately no saving() hook. Model::save() fires "saving" before
 * the isDirty() check, so clearing there fired on every updateOrCreate whether or
 * not anything changed — roughly 700 full cache wipes per hourly import. It also
 * cleared *before* the write, so a concurrent request could repopulate the cache
 * with pre-write data. The hooks below cover every case where data really changed.
 */
class ModelObserver
{
    public function clearCache()
    {
        ContentCache::clear();
    }

    public function created()
    {
        $this->clearCache();
    }

    public function updated()
    {
        $this->clearCache();
    }

    public function deleted()
    {
        $this->clearCache();
    }

    public function restored()
    {
        $this->clearCache();
    }

    public function forceDeleted()
    {
        $this->clearCache();
    }
}
