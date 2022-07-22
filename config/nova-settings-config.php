<?php

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\MultiSelect;

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
        "page" => "Contact Details",
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
