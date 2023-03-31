<?php
namespace App\Nova\Settings;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;

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
            Text::make("Newsletter heading", "newsletter_heading")->help(
                "Title for the newsletter section in the footer"
            ),
            Text::make("Access key", "access_key")->help(
                "Displayed above the accessibility key in the booking path"
            ),
        ];
    }

    public function casts(): array
    {
        return [];
    }
}
