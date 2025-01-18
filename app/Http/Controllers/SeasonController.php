<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Event;
use App\Models\Instance;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SeasonController extends Controller
{
    public function show(Season $season)
    {

        $season->load("featuredImage");
        $season->append("latestPost");

        return view("seasons.show", [
            "season" => $season,
            "entries" =>
            $season->display_type == 'events' ?
                Event::getEventsForSlider('strand', $season->name) : Instance::getInstancesForSlider('strand', $season->name)
        ]);
    }
}
