<?php

namespace App\Livewire;

use App\Models\AccessTag;
use App\Models\Instance;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
        $this->dispatch("scrollToTop");
        $this->dispatch("updateStrand2", $this->strand);
    }

    public function setAccessibility($value)
    {
        $this->type = "schedule";
        $this->accessibility = $value;
        $this->dispatch("scrollToTop");
        $this->dispatch("updateAccessibility2", $this->accessibility);
    }

    public function setDate($value)
    {
        $this->type = "schedule";
        $this->date = $value;
        $this->dispatch("scrollToTop");
        $this->dispatch("updateDate2", $this->date);
    }

    public function render()
    {
        $strands_with_showings = \App\Models\Strand::whereHas("instances")
            ->select("name", "slug", "logo_simple", "color")
            ->get();

        // dd(AccessTag::all());
        // dd(Instance::first());
        $accessibilities_with_showings = AccessTag::all()->filter(fn($tag) => $tag->slug == 'audio_description' || ($tag->slug && in_array($tag->slug, Schema::getColumnListing('instances'))) ? Instance::where($tag->slug, true)->exists() : false);
        // $past = $this->past;

        return view(
            "livewire.programme",
            compact("strands_with_showings", "accessibilities_with_showings")
        );
    }
}
