<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function home()
    {
        return view("pages.show", [
            "page" => Page::where("slug", "/")->firstOrFail(),
        ]);
    }
    public function show(Page $page1, Page $page2 = null, Page $page3 = null)
    {
        $page = $page3 ?? ($page2 ?? $page1);

        // $page->renderedContent = \Advoor\NovaEditorJs\NovaEditorJs::generateHtmlOutput(
        //     $page->content
        // );

        return view("pages.show", [
            "page" => $page,
        ]);
    }
}
