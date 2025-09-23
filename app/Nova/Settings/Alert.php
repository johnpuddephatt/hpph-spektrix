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
            Boolean::make("Replace entire site?", "alert_takeover")->help("If enabled, the alert will replace the entire site content with just the alert message."),
        ];
    }

    public function casts(): array
    {
        return [
            "alert_display_until" => "datetime",
        ];
    }
}
