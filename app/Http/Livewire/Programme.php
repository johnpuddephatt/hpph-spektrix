<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;

class Programme extends Component
{
    public $type = "latest";
    public $strand = null;

    protected $queryString = ["type", "strand"];

    public function updatingStrand($value)
    {
        if ($value) {
            $this->type = "schedule";
        }
    }

    public function render()
    {
        return view("livewire.programme");
    }
}
