<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class Search extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.search', [
            'results' => strlen($this->search) > 1
                ? Event::shownInProgramme()->hasFutureOrRecentInstances()
                    ->where('name', 'like', '%'.$this->search.'%')
                    ->get()
                : [],
        ]);
    }
}
