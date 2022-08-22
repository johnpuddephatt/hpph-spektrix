<?php
namespace App\Nova\Settings;

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
        ];
    }

    public function casts(): array
    {
        return [];
    }
}
