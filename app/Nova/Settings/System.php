<?php
namespace App\Nova\Settings;

use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;

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
        ];
    }

    public function casts(): array
    {
        return [];
    }
}
