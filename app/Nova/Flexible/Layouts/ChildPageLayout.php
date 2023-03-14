<?php namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class ChildPageLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "child-page";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Child page";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make("Page", "page_id")->options(
                \App\Models\Page::find(request()->resourceId)
                    ? \App\Models\Page::find(request()->resourceId)
                        ->children()
                        ->pluck("name", "id")
                    : []
            ),
        ];
    }

    public function getPageAttribute()
    {
        return \App\Models\Page::find($this->page_id);
    }
}
