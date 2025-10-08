<?php

namespace App\Nova\Actions;

use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;

class SaveAndResizeSquareImage
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
            InterventionImage::read($request->file($attribute))
                ->cover(1024, 1024)
                ->encode(
                    new \Intervention\Image\Encoders\JpegEncoder(quality: 75),
                )
        );

        return $filename;
    }
}
