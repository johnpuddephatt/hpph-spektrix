<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Page;
use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class ChildPageLayout extends Layout
{
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'child-page';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Child page';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Page', 'page_id')->options(
                static::cachedOptions(
                    'children:'.request()->resourceId,
                    fn () => Page::find(request()->resourceId)
                        ?->children()
                        ->pluck('name', 'id') ?? []
                )
            ),
        ];
    }

    public function getPageAttribute()
    {
        return Page::find($this->page_id);
    }
}
