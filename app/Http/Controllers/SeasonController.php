<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function show(Season $season)
    {
        $season->load("featuredImage", "instances.event");

        $season->append("latestPost");

        return view("seasons.show", [
            "season" => $season,
        ]);
    }
}
