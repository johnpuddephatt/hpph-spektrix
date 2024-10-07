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
            "instances" =>
            \App\Models\Instance::whereHas('event')->where('season_name', $season->name)->with('event')->get(),
            "coming_soon" => \App\Models\Instance::withoutGlobalScope('not_coming_soon')->whereHas('event', function (Builder $query) {
                $query->whereNotNull('coming_soon');
            })->where('season_name', $season->name)->with('event')->get()
        ]);
    }
}
