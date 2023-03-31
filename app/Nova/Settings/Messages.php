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
        ];
    }

    public function casts(): array
    {
        return [];
    }
}
