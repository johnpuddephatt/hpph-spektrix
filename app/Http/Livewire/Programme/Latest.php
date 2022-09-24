<?php

namespace App\Http\Livewire\Programme;

use Livewire\Component;

class Latest extends Component
{
    public function render()
    {
        return view("livewire.programme.latest", [
            "events" => \App\Models\Event::with(
                "instances",
                "featuredImage"
            )->get(),
        ]);
    }
}
