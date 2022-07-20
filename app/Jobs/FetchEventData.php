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
            "https://system.spektrix.com/" .
                nova_get_setting("spektrix_client_name") .
                "/api/v3/events?instanceStart_from=" .
                \Carbon\Carbon::now()
                    ->subDay()
                    ->format("Y-m-d") .
                "&attribute_Website=HPPH"
        );

        $events = json_decode($res->getBody()->__toString());

        foreach ($events as $event) {
            $event = \App\Models\Event::withoutGlobalScopes()->updateOrCreate(
                ["id" => $event->id],
                [
                    "description" => $event->description ?? null,
                    "duration" => $event->duration ?? null,
                    "is_on_sale" => $event->isOnSale ?? false,
                    "name" => $event->name ?? null,
                    "instance_dates" => $event->instanceDates ?? null,
                    "first_instance_date_time" =>
                        $event->firstInstanceDateTime ?? null,
                    "last_instance_date_time" =>
                        $event->lastInstanceDateTime ?? null,
                    "alternative_content" =>
                        $event->attribute_AlternativeContent ?? false,
                    "archive_film" => $event->attribute_ArchiveFilm ?? false,
                    "audio_description" =>
                        $event->attribute_AudioDescription ?? false,
                    "venue" => $event->attribute_Venue ?? null,
                    "mubigo" => $event->attribute_MUBIGO ?? false,
                    "non_specialist_film" =>
                        $event->attribute_NonSpecialistFilm ?? false,
                    "country_of_origin" =>
                        $event->attribute_CountryOfOrigin ?? null,
                    "director" => $event->attribute_Director ?? null,
                    "distributor" => $event->attribute_Distributor ?? null,
                    "f_rating" => $event->attribute_FRating ?? null,
                    "language" => $event->attribute_Language ?? null,
                    "original_language_title" =>
                        $event->attribute_OriginalLanguageTitle ?? null,
                    "strobe_light_warning" =>
                        $event->attribute_StrobeLightWarning ?? false,
                    "year_of_production" =>
                        $event->attribute_YearOfProduction ?? null,
                    "featuring_stars" => implode(
                        ",",
                        array_filter([
                            $event->attribute_FeaturingStars1 ?? null,
                            $event->attribute_FeaturingStars2 ?? null,
                            $event->attribute_FeaturingStars3 ?? null,
                        ])
                    ),
                    "genres" => implode(
                        ",",
                        array_filter([
                            $event->attribute_Genre1 ?? null,
                            $event->attribute_Genre2 ?? null,
                            $event->attribute_Genre3 ?? null,
                        ])
                    ),
                    "vibes" => implode(
                        ",",
                        array_filter([
                            $event->attribute_Vibe1 ?? null,
                            $event->attribute_Vibe2 ?? null,
                        ])
                    ),
                    "members_offer_available" =>
                        $event->attribute_MembersOfferAvailable ?? false,
                    "certificate_age_guidance" =>
                        $event->attribute_CertificateAgeGuidance ?? null,
                    "live_or_film" => $event->attribute_LiveOrFilm ?? null,
                    // "website" => $event->attribute_Website ?? null,
                ]
            );
        }
    }
}
