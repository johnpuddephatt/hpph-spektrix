<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class StrandController extends Controller
{
    public function show(Strand $strand)
    {
        $strand->load("featuredImage", "instances.event");

        $strand->append("latestPost");
        // if ($strand->latestPost) {
        //     $strand->latestPost->appendImageSrc("wide");
        // }

        return view("strands.show", [
            "strand" => $strand,
            "coming_soon" => \App\Models\Instance::withoutGlobalScope('on_sale')->whereHas('event', function (Builder $query) {
                $query->whereNotNull('coming_soon');
            })->where('strand_name', $strand->name)->get()
        ]);
    }
}
