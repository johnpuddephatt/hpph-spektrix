<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class Shop extends Component
{
    public $selected_type = null;

    protected $queryString = [
        'selected_type' => ['except' => '', 'as' => 'type'],
    ];

    #[On('updateType')]
    public function setType($value)
    {
        $this->selected_type = $value;
    }

    public function render()
    {
        $products = Product::query();

        if ($this->selected_type) {
            $products = $products->where('type', $this->selected_type);
        }

        $products = $products->get();

        $types = Product::pluck('type')->unique();

        return view('livewire.shop', compact('products', 'types'));
    }
}
