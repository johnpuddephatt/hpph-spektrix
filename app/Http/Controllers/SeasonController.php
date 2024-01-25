<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SeasonController extends Controller
{
    public function show(Season $season)
    {
        $season->load("featuredImage", "instances.event");

        $season->append("latestPost");

        return view("seasons.show", [
            "season" => $season,
            "coming_soon" => \App\Models\Instance::whereHas('event', function (Builder $query) {
                $query->whereNotNull('coming_soon');
            })->where('season_name', $season->name)->get()
        ]);
    }
}
