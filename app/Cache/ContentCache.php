<?php

namespace App\Cache;

use App\Models\Instance;
use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

/**
 * Content invalidation, in one place.
 *
 * Clearing stays deliberately coarse — the whole application cache and the whole
 * response cache. That is what guarantees a Nova edit is never missed, and it means
 * a new cached key needs no registration anywhere to be invalidated correctly. The
 * saving is in clearing far less *often*, not in clearing less.
 *
 * defer() exists for imports: a run that touches 643 events should clear once at the
 * end, and only if something actually changed, rather than once per row.
 */
class ContentCache
{
    protected static bool $deferring = false;

    protected static bool $pending = false;

    /**
     * Clear now, or record that a clear is needed if we are inside defer().
     */
    public static function clear(): void
    {
        if (static::$deferring) {
            static::$pending = true;

            return;
        }

        static::flush();
    }

    /**
     * Run $work collecting clear requests, then clear once if anything asked for it.
     */
    public static function defer(callable $work): mixed
    {
        $wasDeferring = static::$deferring;
        static::$deferring = true;

        try {
            return $work();
        } finally {
            static::$deferring = $wasDeferring;

            // Only the outermost defer() flushes, so nesting is safe.
            if (! static::$deferring && static::$pending) {
                static::$pending = false;
                static::flush();
            }
        }
    }

    protected static function flush(): void
    {
        Cache::flush();
        Instance::forgetAccessTags();
        ResponseCache::clear();
    }
}
