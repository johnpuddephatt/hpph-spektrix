<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
