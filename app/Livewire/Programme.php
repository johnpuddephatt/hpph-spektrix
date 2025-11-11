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

    #[Url]
    public ?string $type = "daily";

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

        if (request()->has("type") && in_array(request()->type, ["schedule", "alphabetical", "daily", "past"])) {
            $this->type = request()->type;
        }
    }

    protected $listeners = [
        "updateStrand" => "setStrand",
        "updateAccessibility" => "setAccessibility",
        "updateDate" => "setDate",
        "clearStrand" => "clearStrand",
    ];



    public function setStrand($slug)
    {

        $this->reset();
        $this->type = "schedule";
        $this->strand = $slug;
        // $this->dispatch("scrollToTop");
        $this->dispatch("updateStrand2", slug: $this->strand);
    }

    public function setAccessibility($slug)
    {
        $this->type = "schedule";
        $this->accessibility = $slug;
        $this->dispatch("scrollToTop");
        $this->dispatch("updateAccessibility2", slug: $this->accessibility);
    }

    public function setDate($date)
    {
        $this->type = "schedule";
        $this->date = $date;
        $this->dispatch("scrollToTop");
        $this->dispatch("updateDate2", date: $this->date);
    }

    public function render()
    {
        $strands_with_showings = \App\Models\Strand::whereHas("instances")
            ->select("name", "slug", "logo_simple", "color")
            ->get();
        $accessibilities_with_showings = AccessTag::all()->filter(fn($tag) => $tag->slug == 'audio_description' || (($tag->slug && in_array($tag->slug, Schema::getColumnListing('instances'))) ? Instance::where($tag->slug, true)->exists() : false));
        // $past = $this->past;
        return view(
            "livewire.programme",
            compact("strands_with_showings", "accessibilities_with_showings")
        );
    }
}
