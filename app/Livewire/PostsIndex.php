<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class PostsIndex extends Component
{
    use WithPagination;

    public $selected_tag;
    public $featured_post;
    public $search = "";

    protected $queryString = [
        "selected_tag" => ["except" => "", "as" => "tag"],
        "search" => ["except" => "", "as" => "q"],
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
        $this->dispatch("scrollToTop");
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = \App\Models\Post::with("featuredImage");

        if ($this->selected_tag) {
            $posts->withAnyTags([$this->selected_tag]);
        }

        if (is_string($this->search) && strlen(trim($this->search)) > 2) {
            $term = trim($this->search);
            $posts->where(function (Builder $query) use ($term) {
                $query
                    ->where("title", "like", "%" . $term . "%")
                    ->orWhere("subtitle", "like", "%" . $term . "%");
            });
        }

        return view("livewire.posts-index", [
            "tags" => \App\Models\Tag::withCount("posts")
                ->get()
                ->where("posts_count"),
            "posts" => $posts->latest()->paginate(12),
        ]);
    }
}
