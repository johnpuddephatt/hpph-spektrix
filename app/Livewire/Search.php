<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Search extends Component
{
    public $search = "";

    public function render()
    {
        return view("livewire.search", [
            "results" =>
            strlen($this->search) > 1
                ? \App\Models\Event::shownInProgramme()->hasFutureOrRecentInstances()
                ->where("name", "like", "%" . $this->search . "%")
                ->get()
                : [],
        ]);
    }
}
