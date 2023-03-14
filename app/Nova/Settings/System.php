<?php
namespace App\Nova\Settings;

use Laravel\Nova\Fields\Text;

class System
{
    public $page = "System";

    public function fields(): array
    {
        return [
            Text::make("Google analytics"),
            Text::make("Spektrix custom domain"),
            Text::make("Spektrix client name"),
        ];
    }

    public function casts(): array
    {
        return [];
    }
}
