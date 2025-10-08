<?php

namespace App\Nova\Settings;

use Laravel\Nova\Fields\Text;

class Newsletter
{
    public $page = "Newsletter signup";

    public function fields(): array
    {
        return [
            Text::make("Newsletter heading", "newsletter_heading")->help(
                "Title for the newsletter section in the footer"
            ),
            Text::make("Newsletter action", "newsletter_action")->help(
                "Enter a valid, absolute URL beginning http:// or https://"
            ),
            Text::make("Newsletter redirect", "newsletter_redirect")->help(
                "Enter a relative URL, e.g. /signed-up"
            ),
        ];
    }

    public function casts(): array
    {
        return [];
    }
}
