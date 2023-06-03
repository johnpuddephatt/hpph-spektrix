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
            Text::make("Message", "alert_message"),
            Text::make("Link", "alert_url"),
            Boolean::make("Enabled?", "alert_enabled"),
            DateTime::make("Display until", "alert_display_until"),
        ];
    }

    public function casts(): array
    {
        return [
            "alert_display_until" => "datetime",
        ];
    }
}
