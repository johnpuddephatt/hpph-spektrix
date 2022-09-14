<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $file = $request->file("file");
        $path = $file->store("files");

        if ($path) {
            return [
                "success" => 1,
                "file" => [
                    "url" => url($path),
                    "name" => $file->getClientOriginalName(),
                    "size" => $file->getSize(),
                    "title" => $file->getClientOriginalName(),
                ],
            ];
        }
    }
}
