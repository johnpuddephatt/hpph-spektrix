<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;

class Programme extends Component
{
    public $type = "latest";

    protected $queryString = ["type"];

    public function render()
    {
        return view("livewire.programme");
    }
}
