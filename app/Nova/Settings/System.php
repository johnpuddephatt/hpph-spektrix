<?php

namespace App\Nova\Settings;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use NormanHuth\Values\Values;
use Trin4ik\NovaSwitcher\NovaSwitcher;

class System
{
    public $page = "System";

    public function fields(): array
    {
        return [
            Text::make("Google analytics"),
            Text::make("Spektrix custom domain"),
            Text::make("Spektrix client name"),

            Panel::make("Team link", [
                Select::make("Team page", "team_page")->options(
                    \App\Models\Page::pluck("name", "id")
                ),
                Text::make("Hash", "team_page_hash")->help(
                    "Optional hash to scroll to on the team page. E.g. #team"
                ),
            ]),
            Panel::make("Content warnings", [
                Values::make(
                    "Content warnings to always display",
                    "content_warnings_to_not_hide"
                )->help("Content warnings to always display on the event page"),
            ]),
            Panel::make("Programme", [
                Select::make("Default view", "default_programme_view")->options(
                    [
                        "schedule" => "Schedule",
                        "alphabetical" => "Alphabetical (A-Z)",
                    ]
                ),

                NovaSwitcher::make("Display availabilty badge", "display_availability_badge"),
                Number::make('Availability threshold', 'availability_threshold')
                    ->help('Set the availability below which to show the "Last few" badge. Enter 0.1 for 10%, 0.2 for 20%, etc.')->step(0.01),
            ]),
        ];
    }

    public function casts(): array
    {
        return [
            "content_warnings_to_not_hide" => "array",
        ];
    }
}
