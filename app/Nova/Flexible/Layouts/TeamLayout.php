<?php namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class TeamLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "team";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Team";

    public function getTeamAttribute()
    {
        return \App\Models\User::where("show_in_directory", true)
            ->orderBy("name")
            ->get();
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [Text::make("Title"), Textarea::make("Subtitle")];
    }
}
