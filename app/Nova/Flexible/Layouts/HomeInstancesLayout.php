<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Carbon\Carbon;

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
        if (
            $this->attributes["display"] == "day" &&
            \App\Models\Instance::today()->count()
        ) {
            $options = [
                ["label" => "Today", "offset" => 0, "duration" => 1],
                ["label" => "Tomorrow", "offset" => 1, "duration" => 1],
            ];
        } else {
            logger(7 - Carbon::now()->dayOfWeek);
            $options = [
                [
                    "label" => "This week",
                    "offset" => 0,
                    "duration" => 7 - Carbon::now()->dayOfWeek,
                ],
                [
                    "label" => "Next week",
                    "offset" => 7 - Carbon::now()->dayOfWeek,
                    "duration" => 7,
                ],
            ];
        }
        return compact("options");
    }
}
