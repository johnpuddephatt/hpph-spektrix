<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use Illuminate\Http\Request;

class StrandController extends Controller
{
    public function show(Strand $strand)
    {
        return view("strands.show", [
            "strand" => $strand->load(
                "featuredImage",
                "instances.event"
                // "secondaryImage",
                // "gallery",
                // "posts"
            ),
        ]);
    }
}
