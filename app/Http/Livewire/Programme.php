<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Programme extends Component
{

    public $type = "schedule";

    public $strand = null;
    public $accessibility = null;
    public $date = null;

    // public $past = false;

    protected $queryString = ["type", "strand", "accessibility", "date"];

    public function updatingType($value)
    {
        if ($value !== "schedule") {
            $this->strand = null;
            $this->accessibility = null;
            $this->date = null;
        }
    }

    public function boot()
    {
        if (nova_get_setting("default_programme_view")) {
            $this->type = nova_get_setting("default_programme_view");
        }
    }

    protected $listeners = [
        "updateStrand" => "setStrand",
        "updateAccessibility" => "setAccessibility",
        "updateDate" => "setDate",
        "clearStrand" => "clearStrand",
    ];



    public function setStrand($value)
    {
        // $this->reset();
        $this->type = "schedule";
        $this->strand = $value;
        $this->emit("scrollToTop");
        $this->emit("updateStrand2", $this->strand);
    }

    public function setAccessibility($value)
    {
        $this->type = "schedule";
        $this->accessibility = $value;
        $this->emit("scrollToTop");
        $this->emit("updateAccessibility2", $this->accessibility);
    }

    public function setDate($value)
    {
        $this->type = "schedule";
        $this->date = $value;
        $this->emit("scrollToTop");
        $this->emit("updateDate2", $this->date);
    }

    public function render()
    {
        $strands_with_showings = \App\Models\Strand::whereHas("instances")
            ->select("name", "slug", "logo_simple", "color")
            ->get();

        $accessibilities_with_showings = collect([]);

        if (\App\Models\Instance::signedBsl()->count()) {
            $accessibilities_with_showings->push([
                "label" => "Signed BSL",
                "slug" => "signed-bsl",
                "abbreviation" => "BSL",
            ]);
        }
        if (\App\Models\Event::audioDescribed()->count()) {
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
                "abbreviation" => "Captioned",
            ]);
        }

        if (\App\Models\Instance::autismFriendly()->count()) {
            $accessibilities_with_showings->push([
                "label" => "Autism-friendly",
                "slug" => "autism-friendly",
                "abbreviation" => "Autism",
            ]);
        }

        if (\App\Models\Instance::toddlerFriendly()->count()) {
            $accessibilities_with_showings->push([
                "label" => "Toddler-friendly",
                "slug" => "toddler-friendly",
                "abbreviation" => "Toddler",
            ]);
        }

        // $past = $this->past;

        return view(
            "livewire.programme",
            compact("strands_with_showings", "accessibilities_with_showings")
        );
    }
}
