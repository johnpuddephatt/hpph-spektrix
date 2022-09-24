<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;

class Programme extends Component
{
    public $type = "latest";

    public $strand = null;
    public $season = null;
    public $accessibility = null;
    public $date = null;

    protected $queryString = ["type", "season", "strand", "date"];

    public function updatingType($value)
    {
        if ($value !== "schedule") {
            $this->strand = null;
            $this->season = null;
            $this->accessibility = null;
            $this->date = null;
        }
    }

    protected $listeners = [
        "updateStrand" => "setStrand",
        "updateSeason" => "setSeason",
        "updateAccessibility" => "setAccessibility",
        "updateDate" => "setDate",
    ];

    public function setStrand($value)
    {
        $this->type = "schedule";
        $this->strand = $value;
        $this->emit("updateStrand2", $this->strand);
    }

    public function setSeason($value)
    {
        $this->type = "schedule";
        $this->season = $value;
        $this->emit("updateSeason2", $this->season);
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

        $seasons_with_showings = \App\Models\Season::whereHas("instances")
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
            compact(
                "strands_with_showings",
                "seasons_with_showings",
                "accessibilities_with_showings"
            )
        );
    }
}
