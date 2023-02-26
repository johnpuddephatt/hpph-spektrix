<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use Illuminate\Http\Request;

class StrandController extends Controller
{
    public function show(Strand $strand)
    {
        $strand->load("featuredImage", "instances.event");

        $strand->append("latestPost");
        if ($strand->latestPost) {
            $strand->latestPost->appendImageSrc("wide");
        }

        return view("strands.show", [
            "strand" => $strand,
        ]);
    }
}
