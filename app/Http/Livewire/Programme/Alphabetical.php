<?php

namespace App\Http\Livewire\Programme;

use Livewire\Component;
use Livewire\WithPagination;

class Alphabetical extends Component
{
    use WithPagination;


    public function paginationView()
    {
        return "vendor.livewire.tailwind";
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
        $this->emit('scrollToTop');
    }
    public $past = false;
    protected $queryString = [
        "past" => ["except" => false]
    ];

    public function render()
    {
        $events = \App\Models\Event::shownInProgramme()
            ->orderBy("name")
            ->with("featuredImage", "instances.strand");


        if ($this->past == false) {
            $events = $events->hasFutureInstances();
        }

        $events = $events->paginate(156);
        return view("livewire.programme.alphabetical", compact('events'));
    }
}
