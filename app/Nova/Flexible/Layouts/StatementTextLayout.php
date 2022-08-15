<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Textarea;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class StatementTextLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "statement_text";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Statement text";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [Textarea::make("Title")];
    }
}
