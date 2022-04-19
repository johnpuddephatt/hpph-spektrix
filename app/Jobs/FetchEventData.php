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

class FetchEventData implements ShouldQueue
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
        $client = new Client();
        $res = $client->request(
            "GET",
            // "https://system.spektrix.com/leedsheritagetheatres_run2_1/api/v3/events?startFrom={ date('Y-m-d') }&attribute_Website=Theatres"
            "https://system.spektrix.com/leedsheritagetheatres_run2_1/api/v3/events?startFrom={ date('Y-m-d') }"
        );

        $events = json_decode($res->getBody()->__toString());
        foreach ($events as $event) {
            $event = \App\Models\Event::updateOrCreate(
                ["spektrix_id" => $event->id],
                [
                    "duration" => $event->duration,
                    "is_on_sale" => $event->isOnSale,
                    "name" => $event->name,
                    "instance_dates" => $event->instanceDates,
                    "first_instance_date_time" => $event->firstInstanceDateTime,
                    "last_instance_date_time" => $event->lastInstanceDateTime,
                    "archive_film" => $event->attribute_ArchiveFilm,
                    "audio_description" => $event->attribute_AudioDescription,
                    "mubigo" => $event->attribute_MUBIGO,
                    "non_specialist_film" =>
                        $event->attribute_NonSpecialistFilm,
                    "website" => $event->attribute_Website,
                    "country_of_origin" => $event->attribute_CountryOfOrigin,
                    "director" => $event->attribute_Director,
                    "distributor" => $event->attribute_Distributor,
                    "f_rating" => $event->attribute_FRating,
                    "language" => $event->attribute_Language,
                    "original_language_title" =>
                        $event->attribute_OriginalLanguageTitle,
                    "strand_name" => $event->attribute_Strand ?: null,
                    "year_of_production" => $event->attribute_YearOfProduction,
                    "featuring_stars_1" => $event->attribute_FeaturingStars1,
                    "featuring_stars_2" => $event->attribute_FeaturingStars2,
                    "featuring_stars_3" => $event->attribute_FeaturingStars3,
                    "genre_2" => $event->attribute_Genre2,
                    "vibe_1" => $event->attribute_Vibe1,
                    "vibe_2" => $event->attribute_Vibe2,
                ]
            );
        }

        foreach (
            array_unique(Arr::pluck($events, "attribute_Strand"))
            as $strand
        ) {
            if ($strand) {
                \App\Models\Strand::updateOrCreate(["name" => $strand]);
            }
        }
    }
}
