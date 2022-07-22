<?php

namespace App\Http\Livewire\Programme;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;

class Instances extends Component
{
    public $options;
    public $show_header = true;
    public $show_load_more = false;
    public $selected_option = 0;
    public $page = 1;

    public function render()
    {
        return view("livewire.programme.instances", [
            "instances" => \App\Models\Instance::whereBetween("start", [
                Carbon::today()->addDays(
                    $this->options[$this->selected_option]["offset"]
                ),
                Carbon::today()->addDays(
                    $this->options[$this->selected_option]["offset"] +
                        $this->options[$this->selected_option]["duration"] *
                            $this->page
                ),
            ])
                ->whereHas("event")
                ->with(
                    "event:id,slug,name,description,venue,certificate_age_guidance,year_of_production,duration,genres,vibes",
                    "event.featuredImage",
                    "strand:slug,name,color"
                )

                ->select(
                    "id",
                    "event_id",
                    "start",
                    "captioned",
                    "signed_bsl",
                    "strand_name",
                    "audio_described"
                )
                ->get(),
        ]);
    }
}
