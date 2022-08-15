<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Carbon\Carbon;
use Laravel\Nova\Fields\Select;

class HomeInstancesLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "home_instances";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Home Instances";

    protected $appends = ["options"];

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        // return [
        //     Select::make("Display")->options([
        //         "day" => "Today/tommorrow",
        //         "week" => "This week/next week",
        //     ]),
        // ];
    }

    public function getOptionsAttribute()
    {
        if (
            \App\Models\Instance::today()->count() &&
            \App\Models\Instance::tomorrow()->count()
        ) {
            $options = [
                ["label" => "Today", "offset" => 0, "duration" => 1],
                ["label" => "Tomorrow", "offset" => 1, "duration" => 1],
            ];
        } elseif (\App\Models\Instance::today()->count()) {
            $options = [["label" => "Today", "offset" => 0, "duration" => 1]];
        } elseif (\App\Models\Instance::tomorrow()->count()) {
            $options = [
                ["label" => "Tomorrow", "offset" => 1, "duration" => 1],
            ];
        } else {
            $options = [
                [
                    "label" => "Soon",
                    "offset" => 0,
                    "duration" => 28,
                    "limit" => 6,
                ],
            ];
        }
        return $options;
    }
}
