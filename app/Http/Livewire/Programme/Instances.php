<?php

namespace App\Http\Livewire\Programme;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;

class Instances extends Component
{
    public $options;
    public $dark = false;
    public $show_header = true;
    public $show_load_more = false;
    public $selected_option = 0;
    public $page = 1;

    public function render()
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

        if (isset(((array) $this->options[$this->selected_option])["offset"])) {
            $instances->whereBetween("start", [
                Carbon::today()->addDays(
                    ((array) $this->options[$this->selected_option])["offset"]
                ),
                Carbon::today()->addDays(
                    ((array) $this->options[$this->selected_option])["offset"] +
                        ((array) $this->options[$this->selected_option])[
                            "duration"
                        ] *
                            $this->page
                ),
            ]);
        }

        if (isset(((array) $this->options[$this->selected_option])["limit"])) {
            $instances->take(
                ((array) $this->options[$this->selected_option])["limit"] *
                    $this->page
            );
        }

        return view("livewire.programme.instances", [
            "instances" => $instances->get(),
        ]);
    }
}
