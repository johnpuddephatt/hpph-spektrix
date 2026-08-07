<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use Illuminate\Http\Request;

/**
 * Live seat availability for a set of instances.
 *
 * Exists because availability changes every few minutes while the pages showing it
 * are cached for an hour — rendering the numbers into the HTML froze them. The
 * badge fetches from here instead, and this route is under /api, which is not in
 * the "web" middleware group and so is never response-cached.
 *
 * Reads the cache only. It must never fall through to Spektrix: this is public and
 * unauthenticated, and a cache miss on a large id list would otherwise fan out into
 * one external HTTP call per instance. Populating the cache is cache:availability's
 * job — a miss simply reports unknown, which the badge renders as hidden.
 */
class InstanceAvailabilityController extends Controller
{
    /**
     * Bounds the response and the work done per request.
     */
    protected const MAX_IDS = 200;

    public function __invoke(Request $request)
    {
        $ids = collect(explode(',', (string) $request->query('ids')))
            ->map(fn ($id) => trim($id))
            // Spektrix ids are alphanumeric; anything else is not worth a lookup.
            ->filter(fn ($id) => $id !== '' && ctype_alnum($id))
            ->unique()
            ->take(self::MAX_IDS)
            ->values();

        $store = Instance::availabilityStore();

        return response()->json(
            $ids->mapWithKeys(fn ($id) => [
                $id => $store->get(
                    Instance::availabilityCacheKeyFor($id),
                    Instance::AVAILABILITY_UNKNOWN
                ),
            ])
        );
    }
}
