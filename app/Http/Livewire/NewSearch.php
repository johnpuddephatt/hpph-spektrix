<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class NewSearch extends Component
{
    public $search = "";

    public function render()
    {
        return view("livewire.new-search", [
            "results" =>
            strlen($this->search) > 1
                ? \App\Models\Event::shownInProgramme()
                ->where("name", "like", "%" . $this->search . "%")
                ->orWhereRelation('instances', 'strand_name', 'like', "%" . $this->search . "%")
                ->orWhereRelation('instances', 'season_name', 'like', "%" . $this->search . "%")
                ->with("featuredImage")
                ->get()
                : [],
        ]);
    }
}
