<?php namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class PagesLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "pages";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Pages";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Flexible::make("Child pages", "child_pages")
                ->addLayout(\App\Nova\Flexible\Layouts\ChildPageLayout::class)
                ->addLayout(\App\Nova\Flexible\Layouts\PageLayout::class)
                ->addLayout(\App\Nova\Flexible\Layouts\LinkLayout::class)
                ->button("Add page")
                ->limit(2),
        ];
    }

    public function getChildPagesAttribute()
    {
        return $this->flexible("child_pages", [
            "child-page" => \App\Nova\Flexible\Layouts\ChildPageLayout::class,
            "page" => \App\Nova\Flexible\Layouts\PageLayout::class,
            "link" => \App\Nova\Flexible\Layouts\LinkLayout::class,
        ]);
    }
}
