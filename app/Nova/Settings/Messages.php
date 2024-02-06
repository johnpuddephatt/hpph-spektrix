<?php

namespace App\Nova\Settings;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Panel;

class Messages
{
    public $page = "Messages";

    public function fields(): array
    {
        return [
            Trix::make("No scheduled screenings")->help(
                "Displayed on the film page when there are no scheduled screenings."
            ),

            Text::make("Film page booking button", "showtimes_link")->help(
                "Opens the booking path on the film page"
            ),

            Text::make("Access key", "access_key")->help(
                "Displayed above the accessibility key in the booking path"
            ),

            Text::make(
                "Content guidance unavailable",
                "content_guidance_unavailable"
            )->help("Displayed when content guidance is not available"),

            Text::make(
                "Strobe light warning unavailable",
                "strobe_light_warning_unavailable"
            )->help("Displayed when strobe light warning is not available"),

            Text::make(
                "Screenings coming soon",
                "screenings_coming_soon"
            )->help("Displayed when an event has no future or past instances"),
            Text::make("Screenings ended", "screenings_ended")->help(
                "Displayed when an event has past instances but no future instances"
            ),

            Panel::make("Booking path", [
                Text::make(
                    "Memberships heading",
                    "members_basket_heading"
                )->help("Displayed next to the booking path"),
                Trix::make("Memberships text", "members_basket_text")->help(
                    "Displayed next to the booking path"
                ),
            ]),
        ];
    }

    public function casts(): array
    {
        return [];
    }
}
