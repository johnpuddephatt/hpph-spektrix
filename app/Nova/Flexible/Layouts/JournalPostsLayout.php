<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Post;
use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Outl1ne\MultiselectField\Multiselect;
use Spatie\Tags\Tag;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class JournalPostsLayout extends Layout implements CachableAttributes
{
    use CachesAttributes;
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'journal-posts';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Journal posts';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Number::make('Number of posts'),
            Boolean::make(
                'Don’t include posts already shown on page',
                'omit_posts_already_shown'
            ),
            Multiselect::make('Tags to include')
                ->saveAsJSON()
                ->options(
                    static::cachedOptions('tags', function () {
                        $tags = Tag::pluck('name')->toArray();

                        return array_combine($tags, $tags);
                    })
                )
                ->help('Posts with any of the selected tags will be shown.'),
        ];
    }

    public function getPostsAttribute()
    {
        return $this->remember('posts', 0, function () {
            $query = Post::latest()->take(
                $this->number_of_posts ?? 3
            );

            if ($this->tags_to_include) {
                $query = $query->withAnyTags($this->tags_to_include);
            }

            if ($this->omit_posts_already_shown && isset($GLOBALS['omit'])) {
                $query->whereNotIn('id', $GLOBALS['omit']);
            }

            return $query->with('featuredImage')->get();
        });
    }
}
