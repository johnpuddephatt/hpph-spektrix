<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function home()
    {
        return view("pages.home-page", [
            "page" => Page::where("template", "home-page")
                ->firstOrFail()
                ->resolveContent(),
        ])->render();
    }

    // public function show(Page $page1, Page $page2 = null, Page $page3 = null)
    public function show($slug)
    {
        $slug_parts = explode("/", $slug);
        $page = Page::where("slug", end($slug_parts))->first();

        if (!$page) {
            abort(404);
        }

        if (
            count($slug_parts) > 1 &&
            $page->parent &&
            $page->parent->slug != $slug_parts[count($slug_parts) - 2]
        ) {
            abort(404);
        }

        return view("pages." . $page->template, [
            "page" => $page->resolveContent(),
        ]);
    }
}
