<?php

namespace App\Jobs;

use App\Models\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheInstanceAvailability implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    /**
     * The only place that fetches availability from Spektrix. Instances read from
     * the cache and never call out during a render — see
     * Instance::getAvailabilityAttribute().
     */
    public function handle()
    {
        $count = 0;

        Instance::all()->each(function ($instance) use (&$count) {
            $instance->refreshAvailability();
            $count++;
        });

        Log::channel('spektrix')->info("Cached availability data for {$count} instances.");
    }
}
