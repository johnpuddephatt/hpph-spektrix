<?php

namespace App\Http\Controllers;

use App\Models\Season;
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
                \App\Models\Event::shownInProgramme()->whereHas('allInstances', function (Builder $query) use ($season) {
                    $query->where('season_name', $season->name);
                })->get() :
                \App\Models\Instance::withoutGlobalScope('not_coming_soon')
                ->where('season_name', $season->name)
                ->with('event')
                ->get()
                ->sortBy([
                    fn($a) => $a->event->coming_soon ? 1 : 0,
                    ['start', 'asc'],

                ])

        ]);
    }
}
