<?php
namespace App\Nova\Settings;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Text;
use Outl1ne\NovaSimpleRepeatable\SimpleRepeatable;
use Trin4ik\NovaSwitcher\NovaSwitcher;

class Banner
{
    public $page = "Banner";

    public function fields(): array
    {
        return [
            Boolean::make("Enable banner", "banner_enabled"),
            Text::make("URL", "banner_url"),
            SimpleRepeatable::make("Values", "banner_values", [
                Text::make("Label"),
                NovaSwitcher::make("Bold?"),
            ])->addRowLabel("Add new line"),
        ];
    }

    public function casts(): array
    {
        return [
            "banner_values" => "array",
        ];
    }
}
