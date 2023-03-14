<?php

namespace App\Nova\Flexible\Layouts;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Outl1ne\MultiselectField\Multiselect;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Select;

use Laravel\Nova\Http\Requests\NovaRequest;
use Astrotomic\CachableAttributes\CachesAttributes;
use Astrotomic\CachableAttributes\CachableAttributes;

class JournalPostLayout extends Layout implements CachableAttributes
{
    use CachesAttributes;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "journal-post";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Journal post";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make("Display", "display")->options([
                "related" => "The newest related post",
                "specific" => "A specific post",
                "tagged" => "Tagged",
            ]),

            Select::make("Post", "post_id")
                ->options(\App\Models\Post::pluck("title", "id"))
                ->searchable()
                ->help(
                    'The selected post will be shown if "a specific post" is selected above'
                ),

            Multiselect::make("Tags to include")
                ->saveAsJSON()
                ->options(
                    array_combine(
                        \Spatie\Tags\Tag::pluck("name")->toArray(),
                        \Spatie\Tags\Tag::pluck("name")->toArray()
                    )
                )
                ->help(
                    'A post with any of the selected tags will be shown if "tagged" is selected above'
                ),

            Heading::make("Appearance settings"),
            Boolean::make("Dark?", "dark"),
            Boolean::make("Striped?", "striped"),
        ];
    }

    public function getPostAttribute()
    {
        return $this->remember("posts", 3600, function () {
            if ($this->display == "specific") {
                $post = \App\Models\Post::find($this->post_id);
            }

            if ($this->display == "related" && $this->model->posts) {
                $post = $this->model->posts->first();
            }

            if ($this->display == "tagged") {
                $post = \App\Models\Post::latest()
                    ->withAnyTags($this->tags_to_include)
                    ->first()
                    ->with("featuredImage");
            }

            if (!isset($post) || !$post) {
                return null;
            }

            if (!in_array($post->id, $GLOBALS["omit"] ?? [])) {
                $GLOBALS["omit"][] = $post->id;
            }
            return $post;
        });
    }
}
