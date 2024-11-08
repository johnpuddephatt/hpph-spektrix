<?php

namespace App\Nova\Settings;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Text;
use Outl1ne\NovaSimpleRepeatable\SimpleRepeatable;
use Trin4ik\NovaSwitcher\NovaSwitcher;

class Redirects
{
    public $page = "Redirects";

    public function fields(): array
    {
        return [

            SimpleRepeatable::make("Redirects", "redirects", [
                Text::make("From"),
                Text::make("To"),
                NovaSwitcher::make("Permanent?", "permanent"),
                NovaSwitcher::make("Enabled?", "enabled"),
            ])->addRowLabel("Add new redirect")->help("– Redirects are processed in order from top to bottom. <br>– Redirects specified here will take priority over other urls, e.g. website pages. <br>– Enable the permanent option unless this is only a temporary redirect (one you plan to remove again after a short period).")->stacked(),
        ];
    }

    public function casts(): array
    {
        return [
            "redirects" => "array",
        ];
    }
}
