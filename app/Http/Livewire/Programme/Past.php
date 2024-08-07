<?php

namespace App\Http\Livewire\Programme;

use Livewire\Component;

class Past extends Component
{
    public function render()
    {
        return view('livewire.programme.alphabetical', [
            'events' => \App\Models\Event::shownInProgramme()

                ->orderBy('name')
                ->with('featuredImage', 'instances.strand')
                ->get(),
        ]);
    }
}
