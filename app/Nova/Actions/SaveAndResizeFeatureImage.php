<?php

namespace App\Nova\Actions;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;
use Laravel\Nova\Http\Requests\NovaRequest;

class SaveAndResizeFeatureImage
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
        $filename = $request->$attribute->hashName('features');
        Storage::disk($disk)->put(
            $filename,
            InterventionImage::read($request->file($attribute))
                ->cover(800, 600)
                ->encode(
                    new JpegEncoder(quality: 75),
                )
        );

        return $filename;
    }
}
