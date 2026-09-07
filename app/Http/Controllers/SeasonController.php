<?php

namespace App\Http\Controllers;

use App\Models\Season;

class SeasonController extends Controller
{
    public function show(Season $season)
    {
        $season->load('featuredImage');
        $season->append('latestPost');

        return view('seasons.show', [
            'season' => $season,
        ]);
    }
}
