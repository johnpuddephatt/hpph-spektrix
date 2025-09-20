<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class PostsIndex extends Component
{
    use WithPagination;

    public $selected_tag;
    public $featured_post;

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
        $this->dispatch("scrollToTop");
    }

    public function render()
    {
        $paginated_posts = $this->selected_tag
            ? \App\Models\Post::with("featuredImage")
                ->withAnyTags([$this->selected_tag])
                ->latest()
                ->paginate(12)
            : \App\Models\Post::with("featuredImage")
                ->latest()
                ->paginate(12);

        // $posts = $paginated_posts->getCollection();
        // $posts->each->appendImageSrc("landscape");
        // $paginated_posts->setCollection($posts);

        return view("livewire.posts-index", [
            "tags" => \App\Models\Tag::withCount("posts")
                ->get()
                ->where("posts_count"),
            "posts" => $paginated_posts,
        ]);
    }
}
