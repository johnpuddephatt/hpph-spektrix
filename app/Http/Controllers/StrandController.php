<?php

namespace App\Http\Controllers;

use App\Models\Strand;

class StrandController extends Controller
{
    public function show(Strand $strand)
    {
        $strand->load('featuredImage');
        $strand->append('latestPost');

        return view('strands.show', [
            'strand' => $strand,
        ]);
    }
}
