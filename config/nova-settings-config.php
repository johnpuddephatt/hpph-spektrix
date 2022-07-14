<?php

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Panel;

return [
    [
        "fields" => [
            Text::make("Google analytics"),
            Text::make("Spektrix custom domain"),
            Text::make("Spektrix client name"),
        ],
        "casts" => [],
        "page" => "Services",
    ],

    [
        "fields" => [
            Text::make("Phone"),
            Textarea::make("Address"),
            Textarea::make("Email"),
            Panel::make("Social media", [
                Text::make("Facebook"),
                Text::make("Twitter"),
                Text::make("Instagram"),
            ]),
        ],
        "casts" => [],
        "page" => "Contact Details",
    ],

    [
        "fields" => [
            Text::make("Message"),
            Text::make("Link"),
            Boolean::make("Enabled?"),
            DateTime::make("Display until"),
        ],
        "casts" => [],
        "page" => "Alert",
    ],
];
