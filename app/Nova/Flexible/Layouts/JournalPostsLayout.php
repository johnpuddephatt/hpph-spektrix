<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Outl1ne\MultiselectField\Multiselect;

class JournalPostsLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "journal-posts";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Journal posts";

    protected $appends = ["posts"];

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Number::make("Number of posts"),
            Multiselect::make("Tags to include")
                ->saveAsJSON()
                ->options(
                    array_combine(
                        \Spatie\Tags\Tag::pluck("name")->toArray(),
                        \Spatie\Tags\Tag::pluck("name")->toArray()
                    )
                )
                ->help("Posts with any of the selected tags will be shown."),
        ];
    }

    public function getPostsAttribute()
    {
        return \App\Models\Post::latest()
            ->withAnyTags($this->tags_to_include)
            ->take($this->number_of_posts)
            ->get();
    }
}
