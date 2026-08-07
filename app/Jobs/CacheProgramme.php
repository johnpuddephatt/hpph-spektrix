<?php

namespace App\Jobs;

use App\Models\AccessTag;
use App\Models\Instance;
use App\Models\Strand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * Warms the programme query cache.
 *
 * getInstancesForProgramme() is keyed on past/strand/accessibility/date, and this
 * previously warmed only the default combination — so every filtered view was a
 * cold miss for whichever visitor hit it first. Date is deliberately left unwarmed:
 * it is unbounded, and dated views are a small share of traffic.
 */
class CacheProgramme implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $warmed = 0;

        // The unfiltered view, which is the overwhelming majority of traffic.
        Instance::getInstancesForProgramme(overwriteCache: true);
        $warmed++;

        // The "past" tab.
        Instance::getInstancesForProgramme(past: true, overwriteCache: true);
        $warmed++;

        foreach (Strand::whereHas('instances')->pluck('slug') as $strand) {
            Instance::getInstancesForProgramme(strand: $strand, overwriteCache: true);
            $warmed++;
        }

        foreach ($this->accessibilitySlugs() as $accessibility) {
            Instance::getInstancesForProgramme(accessibility: $accessibility, overwriteCache: true);
            $warmed++;
        }

        Log::info("Warmed {$warmed} programme cache combinations");
    }

    /**
     * The accessibility filters the UI actually offers — same rule as
     * App\Livewire\Programme::render(), which only lists tags that map to a real
     * instances column and have showings.
     */
    protected function accessibilitySlugs(): array
    {
        $columns = Schema::getColumnListing('instances');

        return AccessTag::all()
            ->filter(
                fn ($tag) => $tag->slug === 'audio_description'
                    || (
                        $tag->column
                        && in_array($tag->column, $columns, true)
                        && Instance::where($tag->column, true)->exists()
                    )
            )
            ->pluck('slug')
            ->all();
    }
}
