<?php

namespace App\Nova\Flexible\Layouts\Concerns;

use Closure;

/**
 * Nova rebuilds a resource's whole field list once per row when it renders an
 * index, and every flexible layout registered on that resource is constructed
 * along with it. Any option list built from a query therefore runs once per row
 * — the Season index was issuing ~350 queries because of this. Memoising for the
 * lifetime of the request brings that back to one query per distinct list.
 */
trait CachesOptions
{
    protected static array $optionCache = [];

    protected static function cachedOptions(string $key, Closure $resolver)
    {
        return static::$optionCache[$key] ??= $resolver();
    }
}
