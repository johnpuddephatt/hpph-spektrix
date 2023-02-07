<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;

class Programme extends Component
{
    public $type = "schedule";

    public $strand = null;
    public $accessibility = null;
    public $date = null;
    public $count = null;

    protected $queryString = ["type", "strand", "accessibility", "date"];

    public function updatingType($value)
    {
        if ($value !== "schedule") {
            $this->strand = null;
            $this->accessibility = null;
            $this->date = null;
        }
    }

    protected $listeners = [
        "updateStrand" => "setStrand",
        "updateAccessibility" => "setAccessibility",
        "updateDate" => "setDate",
        "updateCount" => "setCount",
    ];

    public function setCount($value)
    {
        $this->count = $value;
    }

    public function setStrand($value)
    {
        $this->type = "schedule";
        $this->strand = $value;
        $this->emit("updateStrand2", $this->strand);
    }

    public function setAccessibility($value)
    {
        $this->type = "schedule";
        $this->accessibility = $value;
        $this->emit("updateAccessibility2", $this->accessibility);
    }

    public function setDate($value)
    {
        $this->type = "schedule";
        $this->date = $value;
        $this->emit("updateDate2", $this->date);
    }

    public function render()
    {
        $strands_with_showings = \App\Models\Strand::whereHas("instances")
            ->pluck("name", "slug")
            ->toArray();

        $accessibilities_with_showings = [];

        if (\App\Models\Instance::signedBsl()->count()) {
            $accessibilities_with_showings["signed-bsl"] = "Signed BSL";
        }
        if (\App\Models\Instance::audioDescribed()->count()) {
            $accessibilities_with_showings["audio-described"] =
                "Audio Described";
        }
        if (\App\Models\Instance::captioned()->count()) {
            $accessibilities_with_showings["captioned"] = "Captioned";
        }

        return view(
            "livewire.programme",
            compact("strands_with_showings", "accessibilities_with_showings")
        );
    }
}
