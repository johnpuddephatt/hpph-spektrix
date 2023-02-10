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
        "clearStrand" => "clearStrand",
    ];

    // public function resetStrand($value)
    // {
    //     $this->reset("strand");
    //     $this->emit("updateStrand2", $this->strand);
    // }

    // public function resetAccessibility($value)
    // {
    //     $this->reset("accessibility");
    //     $this->emit("updateAccessibility2", $this->accessibility);
    // }

    // public function resetDate($value)
    // {
    //     $this->reset("data");
    //     $this->emit("updateDate2", $this->date);
    // }

    public function setStrand($value)
    {
        // $this->reset();
        $this->type = "schedule";
        $this->strand = $value;
        $this->emit("updateStrand2", $this->strand);
    }

    public function setAccessibility($value)
    {
        // $this->reset();
        $this->type = "schedule";
        $this->accessibility = $value;
        $this->emit("updateAccessibility2", $this->accessibility);
    }

    public function setDate($value)
    {
        // $this->reset();
        $this->type = "schedule";
        $this->date = $value;
        $this->emit("updateDate2", $this->date);
    }

    public function render()
    {
        $strands_with_showings = \App\Models\Strand::whereHas("instances")
            ->select("name", "slug", "logo", "color")
            ->get();

        $accessibilities_with_showings = collect([]);

        if (\App\Models\Instance::signedBsl()->count()) {
            $accessibilities_with_showings->push([
                "label" => "Signed BSL",
                "slug" => "signed-bsl",
                "abbreviation" => "BSL",
            ]);
        }
        if (\App\Models\Instance::audioDescribed()->count()) {
            $accessibilities_with_showings->push([
                "label" => "Audio Described",
                "slug" => "audio-described",
                "abbreviation" => "AD",
            ]);
        }
        if (\App\Models\Instance::captioned()->count()) {
            $accessibilities_with_showings->push([
                "label" => "Captioned",
                "slug" => "captioned",
                "abbreviation" => "C",
            ]);
        }

        return view(
            "livewire.programme",
            compact("strands_with_showings", "accessibilities_with_showings")
        );
    }
}
