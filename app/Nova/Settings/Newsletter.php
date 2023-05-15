<?php
namespace App\Nova\Settings;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Image;
use Intervention\Image\Facades\Image as LaravelImage;
use Illuminate\Support\Facades\Storage;

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
