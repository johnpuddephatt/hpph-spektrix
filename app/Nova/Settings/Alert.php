<?php
namespace App\Nova\Settings;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;

class Alert
{
    public $page = "alert";

    public function fields(): array
    {
        return [
            Text::make("Message"),
            Text::make("Link"),
            Boolean::make("Enabled?"),
            DateTime::make("Display until"),
        ];
    }

    public function casts(): array
    {
        return [
            "display_until" => "datetime",
        ];
    }
}
