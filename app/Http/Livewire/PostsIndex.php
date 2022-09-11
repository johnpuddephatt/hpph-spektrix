<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class PostsIndex extends Component
{
    use WithPagination;

    public $selected_tag;

    protected $queryString = [
        "selected_tag" => ["except" => "", "as" => "tag"],
    ];

    public function paginationView()
    {
        return "vendor.livewire.tailwind";
    }

    public function setTag($tag = null)
    {
        $this->selected_tag = $tag;
    }

    public function updatingSelectedTag()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view("livewire.posts-index", [
            "tags" => \App\Models\Tag::withCount("posts")
                ->get()
                ->where("posts_count"),
            "posts" => $this->selected_tag
                ? \App\Models\Post::withAnyTags([
                    $this->selected_tag,
                ])->paginate(12)
                : \App\Models\Post::paginate(12),
        ]);
    }
}
