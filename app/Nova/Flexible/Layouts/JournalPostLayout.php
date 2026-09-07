<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Post;
use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Outl1ne\MultiselectField\Multiselect;
use Spatie\Tags\Tag;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class JournalPostLayout extends Layout implements CachableAttributes
{
    use CachesAttributes;
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'journal-post';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Journal post';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [

            Text::make('Title')->default('From the HPPH Journal'),
            Boolean::make('Narrow?', 'narrow'),
            Select::make('Display', 'display')
                ->options([
                    'featured' => 'The newest featured post',
                    'related' => 'The newest related post',
                    'specific' => 'A specific post',
                    'tagged' => 'The newest post with a specific tag/tags',
                ])
                ->default('featured')
                ->displayUsingLabels(),

            Select::make('Post', 'post_id')
                ->options(static::cachedOptions('posts', fn () => Post::pluck('title', 'id')))
                ->searchable()
                ->help(
                    'The selected post will be shown if "a specific post" is selected above'
                ),

            Multiselect::make('Tags to include')
                ->saveAsJSON()
                ->options(
                    static::cachedOptions('tags', function () {
                        $tags = Tag::pluck('name')->toArray();

                        return array_combine($tags, $tags);
                    })
                )
                ->help(
                    'A post with any of the selected tags will be shown if "tagged" is selected above'
                ),

            Heading::make('Appearance settings'),
            Boolean::make('Dark?', 'dark'),
            Boolean::make('Striped?', 'striped'),
        ];
    }

    public function getPostAttribute()
    {

        if ($this->display == 'featured') {
            $post = Post::where('featured', true)
                ->latest()
                ->first();
        }

        if ($this->display == 'specific') {
            $post = Post::find($this->post_id);
        }

        if ($this->display == 'related' && $this->model->posts) {
            $post = $this->model->posts->first();
        }

        if ($this->display == 'tagged') {
            $post = Post::latest()
                ->withAnyTags($this->tags_to_include)
                ->with('featuredImage')
                ->first();
        }

        if (! isset($post) || ! $post || ! isset($post->id)) {
            return null;
        }

        if (! in_array($post->id, $GLOBALS['omit'] ?? [])) {
            $GLOBALS['omit'][] = $post->id;
        }

        return $post;
    }
}
