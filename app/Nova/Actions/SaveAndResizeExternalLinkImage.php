<?php
namespace App\Nova\Actions;

use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class SaveAndResizeExternalLinkImage
{
    /**
     * Store the incoming file upload.
     */
    public function __invoke(
        NovaRequest $request,
        $model,
        $attribute,
        $requestAttribute,
        $disk,
        $storagePath
    ) {
        $filename = $request->$attribute->hashName($attribute);
        Storage::disk($disk)->put(
            $filename,
            InterventionImage::make($request->$attribute)
                ->fit(1200, 800)
                ->encode("jpg", 75)
        );

        return $filename;
    }
}
