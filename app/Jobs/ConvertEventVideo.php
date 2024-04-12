<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use FFMpeg;
use Illuminate\Support\Facades\Storage;

class ConvertEventVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $media;

    public function __construct($media)
    {
        $this->media = $media;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $webm_filename =
            $this->media->id .
            "/video-conversions/" .
            $this->media->file_name .
            ".webm";
        $mp4_filename =
            $this->media->id .
            "/video-conversions/" .
            $this->media->file_name .
            ".mp4";

        FFMpeg::fromDisk($this->media->disk)
            ->open($this->media->id . "/" . $this->media->file_name)
            ->export()
            // ->toDisk($this->media->disk)
            ->resize(1280, 720, 'width')
            ->inFormat((new \FFMpeg\Format\Video\WebM())->setKiloBitrate(1800))
            ->addFilter("-an") // mute audio
            ->save($webm_filename)

            ->export()
            ->resize(1280, 720, 'width')
            ->inFormat((new \FFMpeg\Format\Video\X264())->setKiloBitrate(1800))
            ->addFilter("-an") // mute audio
            ->save($mp4_filename);

        $this->media->video_conversions = json_encode([
            "1280x720" => [
                "webm" => $webm_filename,
                "mp4" => $mp4_filename,
            ],
        ]);
        $this->media->save();

        FFMpeg::cleanupTemporaryFiles();
    }
}
