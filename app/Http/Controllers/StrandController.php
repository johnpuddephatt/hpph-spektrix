<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use App\Models\Event;
use App\Models\Instance;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class StrandController extends Controller
{
    public function show(Strand $strand)
    {
        $strand->load("featuredImage");
        $strand->append("latestPost");

        return view("strands.show", [
            "strand" => $strand,
            "entries" =>
            $strand->display_type == 'events' ?
                Event::getEventsForSlider('strand', $strand->name) : Instance::getInstancesForSlider('strand', $strand->name)

        ]);
    }
}
