<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class FetchInstanceData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // \App\Models\Instance::withoutGlobalScopes()->delete();

        $client = new Client();
        $res = $client->request(
            "GET",
            "https://system.spektrix.com/" .
                nova_get_setting("spektrix_client_name") .
                "/api/v3/instances?startFrom=" .
                \Carbon\Carbon::now()
                    ->subDay()
                    ->format("Y-m-d")
        );

        $instances = json_decode($res->getBody()->__toString());

        logger(count($instances) . " instances");

        // Only bring in instances that belong to a cinema event
        $instances = array_filter($instances, function ($instance) {
            return in_array(
                $instance->event->id,
                \App\Models\Event::withoutGlobalScopes()
                    ->pluck("id")
                    ->toArray()
            );
        });

        logger(
            "event ids: " .
                \App\Models\Event::withoutGlobalScopes()
                    ->pluck("id")
                    ->toJson()
        );

        foreach (
            array_unique(Arr::pluck($instances, "attribute_Season"))
            as $season
        ) {
            if ($season) {
                \App\Models\Season::updateOrCreate(["name" => $season]);
            }
        }

        foreach (
            array_unique(Arr::pluck($instances, "attribute_Strand"))
            as $strand
        ) {
            if ($strand) {
                \App\Models\Strand::updateOrCreate(["name" => $strand]);
            }
        }

        foreach ($instances as $instance) {
            \App\Models\Instance::withoutGlobalScopes()->updateOrCreate(
                ["id" => $instance->id],
                [
                    "is_on_sale" => $instance->isOnSale ?? null,
                    "event_id" => $instance->event->id ?? null,
                    "start" => $instance->start ?? null,
                    "start_selling_at_web" =>
                        $instance->startSellingAtWeb ?? null,
                    "stop_selling_at_web" =>
                        $instance->stopSellingAtWeb ?? null,
                    "cancelled" => $instance->cancelled ?? null,
                    "audio_described" =>
                        $instance->attribute_AudioDescribed ?? null,
                    "captioned" => $instance->attribute_Captioned ?? null,
                    "signed_bsl" => $instance->attribute_SignedBSL ?? null,
                    "special_event" =>
                        $instance->attribute_SpecialEvent ?? null,
                    "accessibility" =>
                        $instance->attribute_Accessiblity ?? null,
                    "analogue" => $instance->attribute_Analogue ?? null,
                    "door_time" => $instance->attribute_DoorTime ?? null,
                    "short_playing_with_feature" =>
                        $instance->attribute_ShortPlayingWithFeature ?? null,
                    "special_event_into_qa_panel" =>
                        $instance->attribute_SpecialEventIntoQAPanel ?? null,
                    "partnership" => $instance->attribute_Partnership ?? null,

                    "season_name" => $instance->attribute_Season ?: null,
                    "strand_name" => $instance->attribute_Strand ?: null,
                ]
            );
        }
    }
}
