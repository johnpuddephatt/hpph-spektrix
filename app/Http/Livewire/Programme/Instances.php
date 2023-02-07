<?php

namespace App\Http\Livewire\Programme;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Instances extends Component
{
    public $options;
    public $dark = false;
    public $show_header = true;
    public $show_load_more = false;
    public $page = 1;

    public $strand = null;
    public $accessibility = null;
    public $date = null;

    public function instances()
    {
        $instances = \App\Models\Instance::whereHas("event")
            ->with(
                "event:id,slug,name,description,certificate_age_guidance,year_of_production,duration,genres,vibes",
                "event.featuredImage",
                "strand:slug,name,color"
            )
            ->select(
                "id",
                "venue",
                "event_id",
                "start",
                "captioned",
                "signed_bsl",
                "strand_name",
                "audio_described"
            );

        if ($this->strand) {
            $strand = $this->strand;
            $instances->whereHas("strand", function (Builder $query) use (
                $strand
            ) {
                $query->where("strands.slug", $strand);
            });
        }

        if ($this->accessibility) {
            $instances->{Str::camel($this->accessibility)}();
        }

        if ($this->date) {
            $instances->whereDate("start", $this->date);
        }

        return $instances;
    }

    protected $queryString = ["accessibility", "strand", "date"];

    protected $listeners = [
        "updateStrand2" => "setStrand",
        "updateAccessibility2" => "setAccessibility",
        "updateDate2" => "setDate",
    ];

    public function clearFilters()
    {
        $this->strand = null;
        $this->accessibility = null;
        $this->date = null;
    }

    public function setStrand($value)
    {
        $this->clearFilters();
        $this->strand = $value;
    }

    public function setAccessibility($value)
    {
        $this->clearFilters();
        $this->accessibility = $value;
    }

    public function setDate($value)
    {
        $this->clearFilters();
        $this->date = $value;
    }

    public function render()
    {
        $this->emit("updateCount", $this->instances()->count());
        return view("livewire.programme.instances", [
            "instances" => $this->instances()->get(),
            "page_title" => "wow",
        ]);
    }
}
