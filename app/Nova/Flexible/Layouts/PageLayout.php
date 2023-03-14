<?php namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class PageLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "page";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Page";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make("Page", "page_id")
                ->options(\App\Models\Page::pluck("name", "id") ?? [])
                ->searchable(),
        ];
    }

    public function getPageAttribute()
    {
        return \App\Models\Page::find($this->page_id);
    }
}
