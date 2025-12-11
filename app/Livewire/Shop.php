<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\Attributes\On;
use Carbon\Carbon;

class Shop extends Component
{
    public $selected_type = null;

    protected $queryString = [
        "selected_type" => ["except" => "", "as" => "type"],
    ];

    #[On('updateType')]
    public function setType($value)
    {
        $this->selected_type = $value;
    }

    public function render()
    {
        $products = \App\Models\Product::query();

        if ($this->selected_type) {
            $products = $products->where("type", $this->selected_type);
        }

        $products = $products->get();

        $types = \App\Models\Product::pluck("type")->unique();

        return view("livewire.shop", compact("products", "types"));
    }
}
