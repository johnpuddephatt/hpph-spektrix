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
            strlen($this->search) > 2
                ? \App\Models\Event::shownInProgramme()
                ->hasFutureOrRecentInstances()
                ->where(function (Builder $query) {
                    $query->where("name", "like", "%" . $this->search . "%")
                        ->orWhere("subtitle", "like", "%" . $this->search . "%")
                        ->orWhere("director", "like", "%" . $this->search . "%")
                        ->orWhereRelation('instances', 'strand_name', 'like', "%" . $this->search . "%")
                        ->orWhereRelation('instances', 'season_name', 'like', "%" . $this->search . "%");
                })
                ->with("featuredImage")
                ->get()
                : [],
        ]);
    }
}
