<?php

namespace App\Observers;

use App\Cache\ContentCache;

/**
 * Access tags feed several derived caches — accessibilities_with_showings, and
 * every instance's access_tags — so this clears the lot rather than forgetting
 * "access_tags" alone. A missed key here is a staff edit that never appears, and
 * access tags are edited rarely enough that over-clearing costs nothing.
 *
 * No saving() hook: see ModelObserver.
 */
class AccessTagsObserver
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
