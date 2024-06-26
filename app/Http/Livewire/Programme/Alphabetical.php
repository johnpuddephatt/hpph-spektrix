<?php

namespace App\Http\Livewire\Programme;

use Livewire\Component;

class Alphabetical extends Component
{
    public function render()
    {
        return view("livewire.programme.alphabetical", [
            "events" => \App\Models\Event::shownInProgramme()
                ->hasFutureInstances()
                ->orderBy("name")
                ->with("featuredImage", "instances.strand")
                ->get(),
        ]);
    }
}
