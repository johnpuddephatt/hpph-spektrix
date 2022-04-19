<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function show($page1, $page2 = null, $page3 = null, $page4 = null)
    {
        if ($page4) {
            $page4 = \App\Models\Page::where("slug", $page4)->firstorfail();
        }
        if ($page3) {
            $page3 = \App\Models\Page::where("slug", $page3)->firstorfail();
        }
        if ($page2) {
            $page2 = \App\Models\Page::where("slug", $page2)->firstorfail();
        }
        if ($page1) {
            $page1 = \App\Models\Page::where("slug", $page1)->firstorfail();
        }

        $page = $page4 ?? ($page3 ?? ($page2 ?? $page1));

        $page->renderedContent = \Advoor\NovaEditorJs\NovaEditorJs::generateHtmlOutput(
            $page->content
        );

        return view("pages.show", [
            "page" => $page,
        ]);
    }
}
