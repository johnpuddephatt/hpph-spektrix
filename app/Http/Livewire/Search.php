<?php

namespace App\Http\Livewire;

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
                ? \App\Models\Event::shownInProgramme()
                ->where("name", "like", "%" . $this->search . "%")
                ->orWhereHas('instances', function (Builder $query) {
                    $query->where('season_name', 'like', '%')->orWhere('strand_name', 'like', '%');
                })
                ->with("featuredImage")
                // ->select("name", "slug", "language", "date_range")
                ->get()
                : [],
        ]);
    }
}
