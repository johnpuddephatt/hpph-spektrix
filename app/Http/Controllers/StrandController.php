<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class StrandController extends Controller
{
    public function show(Strand $strand)
    {
        $strand->load("featuredImage");
        $strand->append("latestPost");
        // if ($strand->latestPost) {
        //     $strand->latestPost->appendImageSrc("wide");
        // }


        return view("strands.show", [
            "strand" => $strand,
            "entries" =>
            $strand->display_type == 'events' ?
                \App\Models\Event::shownInProgramme()->whereHas('allInstances', function (Builder $query) use ($strand) {
                    $query->where('strand_name', $strand->name);
                })->get() :
                \App\Models\Instance::withoutGlobalScope('not_coming_soon')
                ->where('strand_name', $strand->name)
                ->with('event')
                ->get()
                ->sortBy([
                    fn($a) => $a->event->coming_soon ? 1 : -1,
                    ['start', 'asc'],
                ])

        ]);
    }
}
