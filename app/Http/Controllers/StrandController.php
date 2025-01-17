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

            "instances" =>
            $strand->display_type == 'instances' ?
                // \App\Models\Instance::whereHas('event')
                // ->where('strand_name', $strand->name)
                // ->with('event')
                // ->get()
                // ->concat(
                \App\Models\Instance::withoutGlobalScope('not_coming_soon')
                // ->whereHas('event', function (Builder $query) {
                //     $query->whereNotNull('coming_soon');
                // })
                ->where('strand_name', $strand->name)
                ->with('event')
                ->get()
                // ) 
                : null,

            // "coming_soon_instances" => $strand->display_type == 'instances' ?  \App\Models\Instance::withoutGlobalScope('not_coming_soon')->whereHas('event', function (Builder $query) {
            //     $query->whereNotNull('coming_soon');
            // })->where('strand_name', $strand->name)->with('event')->get() : null,

            // 'events' => $strand->display_type == 'events' ? \App\Models\Event::whereHas('instances', function (Builder $query) use ($strand) {
            //     $query->where('strand_name', $strand->name);
            // })->get() : null,

            // 'coming_soon_events' => $strand->display_type == 'events' ? \App\Models\Event::whereHas('instances', function (Builder $query) use ($strand) {
            //     $query->where('strand_name', $strand->name);
            // })->whereNotNull('coming_soon')->get() : null
        ]);
    }
}
