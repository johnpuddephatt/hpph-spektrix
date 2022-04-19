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
        \App\Models\Instance::query()->delete();

        $client = new Client();
        $res = $client->request(
            "GET",
            "https://system.spektrix.com/leedsheritagetheatres_run2_1/api/v3/instances?startFrom={ date('Y-m-d') }"
        );

        $instances = json_decode($res->getBody()->__toString());

        $event_spektrix_ids = \App\Models\Event::pluck(
            "spektrix_id"
        )->toArray();

        // Only bring in instances that belong to a cinema event
        $instances = array_filter($instances, function ($instance) use (
            $event_spektrix_ids
        ) {
            return in_array($instance->event->id, $event_spektrix_ids);
        });

        foreach ($instances as $instance) {
            \App\Models\Instance::updateOrCreate(
                ["spektrix_id" => $instance->id],
                [
                    "is_on_sale" => $instance->isOnSale,
                    "event_id" => $instance->event->id,
                    "start" => $instance->start,
                    "start_selling_at_web" => $instance->startSellingAtWeb,
                    "stop_selling_at_web" => $instance->stopSellingAtWeb,
                    "cancelled" => $instance->cancelled,
                    "analogue" => $instance->attribute_Analogue,
                    "captioned" => $instance->attribute_Captioned,
                    "special_event" => $instance->attribute_SpecialEvent,
                    "short_film_with_feature" =>
                        $instance->attribute_ShortFilmWithFeature,
                    "audio_described" => $instance->attribute_AudioDescribed,
                    "season_name" => $instance->attribute_Season ?: null,
                    "target_audience" => $instance->attribute_TargetAudience1,
                    "target_audience_2" => $instance->attribute_TargetAudience2,
                    "signed_bsl" => $instance->attribute_SignedBSL,
                    "relaxed_performance" =>
                        $instance->attribute_RelaxedPerformance,
                ]
            );
        }

        foreach (
            array_unique(Arr::pluck($instances, "attribute_Season"))
            as $season
        ) {
            if ($season) {
                \App\Models\Season::updateOrCreate(["name" => $season]);
            }
        }
    }
}
