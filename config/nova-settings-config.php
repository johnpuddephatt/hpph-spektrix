<?php

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use OptimistDigital\NovaTableField\Table;

use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\KeyValue;

return [
    [
        "page" => "Services",
        "fields" => [
            Text::make("Google analytics"),
            Text::make("Spektrix custom domain"),
            Text::make("Spektrix client name"),
        ],
        "casts" => [],
    ],

    [
        "page" => "Cinema Details",
        "fields" => [
            Text::make("Phone")->help("foo"),
            Text::make("Address"),
            KeyValue::make("Email addresses")
                ->keyLabel("Name")
                ->valueLabel("Email address")
                ->actionText("Add address")
                ->rules("json"),
            Text::make("Charity number"),
            Panel::make("Opening hours", [
                KeyValue::make("Opening hours")
                    ->keyLabel("Day(s)")
                    ->valueLabel("Hours")
                    ->actionText("Add row")
                    ->rules("json"),
            ]),
            Panel::make("Social media", [
                Text::make("Facebook"),
                Text::make("Twitter"),
                Text::make("Instagram"),
                Text::make("LinkedIn"),
                Text::make("Vimeo"),
                Text::make("YouTube"),
            ]),
        ],
        "casts" => [
            "email_addresses" => "array",
            "opening_hours" => "array",
        ],
    ],

    [
        "page" => "Messages",
        "fields" => [
            Trix::make("No scheduled screenings")->help(
                "Displayed on the film page when there are no scheduled screenings."
            ),
        ],
        "casts" => [],
    ],

    [
        "page" => "Alert",
        "fields" => [
            Text::make("Message"),
            Text::make("Link"),
            Boolean::make("Enabled?"),
            DateTime::make("Display until"),
        ],
        "casts" => [],
    ],
];
