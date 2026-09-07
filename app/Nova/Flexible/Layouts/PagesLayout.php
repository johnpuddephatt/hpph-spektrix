<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class PagesLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'pages';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Pages';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Flexible::make('Child pages', 'child_pages')
                ->addLayout(ChildPageLayout::class)
                ->addLayout(PageLayout::class)
                ->addLayout(LinkLayout::class)
                ->button('Add page')
                ->fullWidth()
                ->limit(2),
        ];
    }

    public function getChildPagesAttribute()
    {
        return $this->flexible('child_pages', [
            'child-page' => ChildPageLayout::class,
            'page' => PageLayout::class,
            'link' => LinkLayout::class,
        ]);
    }
}
