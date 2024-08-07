<?php

namespace App\Http\Livewire\Programme;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Instances extends Component
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


    public function instances()
    {
        $instances = \App\Models\Instance::whereHas("event", function ($event) {
            return $event->shownInProgramme();
        })
            ->with(
                "event:id,slug,name,subtitle,description,certificate_age_guidance,duration,audio_description",
                "event.featuredImage",
                "strand:slug,name,color,show_on_instance_card"
            )
            ->select(
                "id",
                "event_id",
                "start",
                "captioned",
                "relaxed",
                "autism_friendly",
                "signed_bsl",
                "analogue",
                "strand_name",
                "special_event",
                "external_ticket_link"

            );

        if ($this->past == true) {
            $instances->withoutGlobalScope("future");
        }

        $this->filtered = false;

        if ($this->strand) {
            $strand = $this->strand;
            $instances->whereHas("strand", function (Builder $query) use (
                $strand
            ) {
                $query->where("strands.slug", $strand);
            });
            $this->filtered = true;
        }

        if ($this->accessibility) {
            $instances->{Str::camel($this->accessibility)}();
            $this->filtered = true;
        }

        if ($this->date) {
            $instances->whereDate("start", $this->date);
            $this->filtered = true;
        }

        return $instances;
    }

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

    public function setStrand($value)
    {
        // $this->clearFilters();
        $this->resetPage();

        $this->strand = $value;
    }

    public function setAccessibility($value)
    {
        // $this->clearFilters();
        $this->resetPage();

        $this->accessibility = $value;
    }

    public function setDate($value)
    {
        // $this->clearFilters();
        $this->resetPage();

        $this->date = $value;
    }

    public function render()
    {
        return view("livewire.programme.instances", [
            "instances" => $this->instances()->paginate(150),
        ]);
    }
}
