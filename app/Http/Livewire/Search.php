<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Search extends Component
{
    public $search = "";

    public function render()
    {
        return view("livewire.search", [
            "results" =>
                strlen($this->search) > 1
                    ? \App\Models\Event::shownInProgramme()
                        ->where("name", "like", "%" . $this->search . "%")
                        ->select("name", "slug", "language")
                        ->get()
                    : [],
        ]);
    }
}
