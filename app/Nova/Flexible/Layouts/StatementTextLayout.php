<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;

class StatementTextLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "statementtextlayout";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "StatementTextLayout";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            "title" => $this->attributes["title"],
        ];
    }
}
