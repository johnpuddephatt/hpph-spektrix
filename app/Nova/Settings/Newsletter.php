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
            Text::make("Title", "newsletter_title")->help(
                "Supports markdown – e.g. **bold**"
            ),
            Text::make("Message", "newsletter_message"),
            Text::make("Link", "newsletter_link"),
            Image::make("Image", "newsletter_image")
                ->maxWidth(50)
                ->disableDownload()
                ->store(function (Request $request, $model) {
                    $image = LaravelImage::make($request->newsletter_image)
                        ->fit(840, 560)
                        ->encode("jpg", 80);

                    Storage::disk("public")->put(
                        "/newsletter/" .
                            $request->newsletter_image->getClientOriginalName(),
                        $image
                    );

                    return "/newsletter/" .
                        $request->newsletter_image->getClientOriginalName();
                }),
        ];
    }

    public function casts(): array
    {
        return [];
    }
}
