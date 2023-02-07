<?php

namespace App\Observers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Jobs\ConvertEventVideo;
class MediaObserver
{
    /**
     * Handle the Media "created" event.
     * @return void
     */
    public function created(Media $media)
    {
        if ($media->collection_name == "video") {
            ConvertEventVideo::dispatch($media);
        }
    }

    /**
     * Handle the Media "updated" event.
     * @return void
     */
    public function updated(Media $media)
    {
    }

    /**
     * Handle the Media "deleted" event.
     * @return void
     */
    public function deleted()
    {
    }

    /**
     * Handle the Media "restored" event.
     * @return void
     */
    public function restored()
    {
    }

    /**
     * Handle the Media "force deleted" event.
     * @return void
     */
    public function forceDeleted()
    {
    }

    /**
     * Handle the Media "saving" event.
     * @return void
     */
    public function saving()
    {
    }
}
