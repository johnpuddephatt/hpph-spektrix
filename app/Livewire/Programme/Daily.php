<?php

namespace App\Livewire\Programme;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Daily extends Component
{
    use WithPagination;


    public function paginationView()
    {
        return "vendor.livewire.tailwind";
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
        $this->dispatch('scrollToTop');
    }

    public $options;
    public $dark = false;
    public $show_header = true;
    public $show_load_more = false;
    public $page = 1;

    public $strand = null;
    public $accessibility = null;
    public $date = null;

    public $filtered = false;

    public $past = false;

    protected $queryString = ["accessibility", "strand", "date", "past" => ["except" => false]];

    protected $listeners = [
        "updateStrand2" => "setStrand",
        "updateAccessibility2" => "setAccessibility",
        "updateDate2" => "setDate",
    ];

    public function clearFilters()
    {
        $this->reset("strand");
        $this->reset("accessibility");
        $this->reset("date");
    }

    public function setStrand($slug)
    {

        // $this->clearFilters();
        $this->resetPage();

        $this->strand = $slug;
    }

    public function setAccessibility($slug)
    {
        // $this->clearFilters();
        $this->resetPage();

        $this->accessibility = $slug;
    }

    public function setDate($date)
    {
        // $this->clearFilters();
        $this->resetPage();

        $this->date = $date;
    }

    public function render()
    {
        return view("livewire.programme.daily", [
            "instances" => \App\Models\Instance::getInstancesForProgramme(
                $this->past,
                $this->strand,
                $this->accessibility,
                $this->date
            )->groupBy(['start_date' => function ($date) {
                return Carbon::parse($date->start)->format('Y-m-d');
            }, 'event_id']),
        ]);
    }
}
