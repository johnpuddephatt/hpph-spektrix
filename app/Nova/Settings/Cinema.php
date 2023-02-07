<?php
namespace App\Nova\Settings;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\KeyValue;

class Cinema
{
    public $page = "Cinema";

    public function fields(): array
    {
        return [
            Text::make("Phone")->help("foo"),
            Text::make("Address"),
            KeyValue::make("Email addresses")
                ->keyLabel("Name")
                ->valueLabel("Email address")
                ->actionText("Add address")
                ->rules("json"),
            Text::make("Charity number"),
            // Panel::make("Opening hours", [
            //     KeyValue::make("Opening hours")
            //         ->keyLabel("Day(s)")
            //         ->valueLabel("Hours")
            //         ->actionText("Add row")
            //         ->rules("json"),
            // ]),
            Panel::make("Social media", [
                Text::make("Facebook"),
                Text::make("Twitter"),
                Text::make("Instagram"),
                Text::make("LinkedIn"),
                Text::make("Vimeo"),
                Text::make("YouTube"),
            ]),
        ];
    }

    public function casts(): array
    {
        return [
            "email_addresses" => "array",
            // "opening_hours" => "array",
        ];
    }
}
