<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;

class HomeInstancesLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "homeinstanceslayout";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "HomeInstancesLayout";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        if ($this->attributes["display"] == "day") {
            $options = [
                ["label" => "Today", "offset" => 0, "duration" => 1],
                ["label" => "Tomorrow", "offset" => 1, "duration" => 1],
            ];
        }
        if ($this->attributes["display"] == "week") {
            $options = [
                ["label" => "This week", "offset" => 0, "duration" => 7],
                ["label" => "Next week", "offset" => 7, "duration" => 7],
            ];
        }
        return compact("options");
    }
}
