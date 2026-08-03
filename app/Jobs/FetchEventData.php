<?php

namespace App\Jobs;

use App\Models\Instance;
use App\Support\ColumnLimits;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\ResponseCache\Facades\ResponseCache;

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

    public function fetch($url)
    {
        $client = new Client();
        $res = $client->request("GET", $url);
        return json_decode($res->getBody()->__toString(), false);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Schema::disableForeignKeyConstraints();

        $hpph_events = $this->getEvents('HPPH');
        $both_events = $this->getEvents('Both');

        $events = array_merge($hpph_events, $both_events);
        $instances = $this->getInstances($events);
        $this->getInstancesVenues($instances);

        // Strand/season names are both the upsert key and the pivot lookup key, so
        // truncate them once, up front, keeping row creation and pivot syncing consistent.
        $this->truncateNameAttributes($instances);

        $this->updateOrCreateEvents($events);
        $this->updateOrCreateSeasons($instances);
        $this->updateOrCreateStrands($instances);
        $this->updateOrCreateInstances($instances);
        Schema::enableForeignKeyConstraints();

        ResponseCache::clear();
        Cache::flush();
        Instance::getInstancesForProgramme(false, null, null, null, true);

        Log::channel("spektrix")->info("Imported " . count($events) . " events (" . count($instances) . " instances)");
    }

    /**
     * Trim and truncate the strand/season name attributes on each instance
     * before they are used as upsert keys and pivot lookup keys. Names are typed
     * by hand in Spektrix, so stray leading/trailing spaces are common.
     */
    public function truncateNameAttributes($instances)
    {
        foreach ($instances as $instance) {
            foreach (["attribute_Strand", "attribute_Strand2"] as $attribute) {
                if (! empty($instance->{$attribute})) {
                    $instance->{$attribute} = ColumnLimits::fitValue("strands", "name", trim($instance->{$attribute}));
                }
            }
            foreach (["attribute_Season", "attribute_Season2"] as $attribute) {
                if (! empty($instance->{$attribute})) {
                    $instance->{$attribute} = ColumnLimits::fitValue("seasons", "name", trim($instance->{$attribute}));
                }
            }
        }
    }

    public function getEvents($website = "HPPH")
    {
        return $this->fetch(
            "https://system.spektrix.com/" .
                nova_get_setting("spektrix_client_name") .
                "/api/v3/events?instanceStart_from=" .
                \Carbon\Carbon::now()
                ->subDay()
                ->format("Y-m-d") .
                "&attribute_Website=" . $website
        );
    }

    public function getInstances($events)
    {
        $instances = [];
        foreach ($events as $event) {
            $instances = array_merge(
                $instances,
                $this->fetch(
                    "https://system.spektrix.com/" .
                        nova_get_setting("spektrix_client_name") .
                        "/api/v3/events/{$event->id}/instances?start_from=" .
                        \Carbon\Carbon::now()
                        ->subDay()
                        ->format("Y-m-d")
                )
            );
        }
        return $instances;
    }

    public function updateOrCreateEvents($events)
    {
        foreach ($events as $event) {
            // \App\Models\Event::withoutEvents(function () use ($event) {
            \App\Models\Event::withoutGlobalScopes()->updateOrCreate(
                ["id" => $event->id],
                ColumnLimits::fit("events", [
                    "enabled" => true,
                    "duration" => $event->duration ?? null,
                    "is_on_sale" => $event->isOnSale ?? false,
                    "name" => $event->name ? Str::limit($event->name, 200) : null,
                    "subtitle" => $event->attribute_Subtitle ?? null,
                    "first_instance_date_time" =>
                    $event->firstInstanceDateTime ?? null,
                    "last_instance_date_time" =>
                    $event->lastInstanceDateTime ?? null,
                    "audio_description" =>
                    $event->attribute_AudioDescription ?? false,
                    "country_of_origin" =>
                    $event->attribute_CountryOfOrigin ?? null,
                    "director" => $event->attribute_Director ?? null,
                    "distributor" => $event->attribute_Distributor ?? null,
                    "f_rating" => $event->attribute_FRating ?? null,
                    "language" => $event->attribute_Language ?? null,
                    "original_language_title" =>
                    $event->attribute_OriginalLanguageTitle ?? null,
                    "strobe_light_warning" =>
                    $event->attribute_StrobeLightWarning ?? null,
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
                    "content_guidance" => implode(
                        ",",
                        array_filter([
                            $event->attribute_ContentGuidance1 ?? null,
                            $event->attribute_ContentGuidance2 ?? null,
                            $event->attribute_ContentGuidance3 ?? null,
                        ])
                    ),
                    "certificate_age_guidance" =>
                    $event->attribute_CertificateAgeGuidance ?? null,
                    "coming_soon" => $event->attribute_ComingSoon ?: null,

                    // Unused (checked August 2025)

                    // "website" => $event->attribute_Website ?? null,
                    // "description" => $event->description ?? null, // we don't want to use the Spektrix description
                    "members_offer_available" =>
                    $event->attribute_MembersOfferAvailable ?? false,
                    "live_or_film" => $event->attribute_LiveOrFilm ?? null,
                    "non_specialist_film" =>
                    $event->attribute_NonSpecialistFilm ?? false,
                    "mubigo" => $event->attribute_MUBIGO ?? false,
                    "archive_film" => $event->attribute_ArchiveFilm ?? false,
                    "alternative_content" =>
                    $event->attribute_AlternativeContent ?? false,
                    "instance_dates" => $event->instanceDates ?? null,

                ])
            );
            // });
        }
        \App\Models\Event::withoutGlobalScopes()->whereNotIn('id', Arr::pluck($events, 'id'))->update(["enabled" => false]);
    }

    public function getInstancesVenues($instances)
    {
        foreach ($instances as $instance) {
            if (!$instance->planId) {
                return null;
            }
            $plan = $this->fetch(
                "https://system.spektrix.com/" .
                    nova_get_setting("spektrix_client_name") .
                    "/api/v3/plans/{$instance->planId}"
            );
            if (!$plan) {
                return null;
            }
            $venue = $this->fetch(
                "https://system.spektrix.com/" .
                    nova_get_setting("spektrix_client_name") .
                    "/api/v3/venues/{$plan->venue->id}"
            );

            $instance->venue = $venue->name;
        }
    }

    public function updateOrCreateStrands($instances)
    {
        \App\Models\Strand::query()->update(["enabled" => false]);

        foreach (
            array_unique(array_merge(
                Arr::pluck($instances, "attribute_Strand"),
                Arr::pluck($instances, "attribute_Strand2")
            ))
            as $strand
        ) {
            if ($strand) {
                // Only "name" on create: the lookup is case-insensitive in MySQL, so
                // writing it back would rewrite an existing row's name to whichever
                // casing Spektrix happened to send last.
                \App\Models\Strand::withoutGlobalScopes()->updateOrCreate(
                    [
                        "name" => $strand,
                    ],
                    [
                        "enabled" => true,
                    ]
                );
            }
        }
    }

    public function updateOrCreateSeasons($instances)
    {
        \App\Models\Season::query()->update(["enabled" => false]);

        foreach (
            array_unique(array_merge(
                Arr::pluck($instances, "attribute_Season"),
                Arr::pluck($instances, "attribute_Season2")
            ))
            as $season
        ) {
            if ($season) {
                // See updateOrCreateStrands: don't rewrite the name of a matched row.
                \App\Models\Season::withoutGlobalScopes()->updateOrCreate(
                    [
                        "name" => $season,
                    ],
                    [
                        "enabled" => true,
                    ]
                );
            }
        }
    }

    public function updateOrCreateInstances($instances)
    {
        // Resolve strand/season names → ids once for pivot syncing.
        $strandIds = $this->nameLookup(\App\Models\Strand::class);
        $seasonIds = $this->nameLookup(\App\Models\Season::class);

        foreach ($instances as $instance) {
            $model = \App\Models\Instance::withoutGlobalScopes()->updateOrCreate(
                ["id" => $instance->id],
                ColumnLimits::fit("instances", [
                    "enabled" => true,
                    "is_on_sale" => $instance->isOnSale ?? null,
                    "event_id" => $instance->event->id ?? null,
                    "venue" => $instance->venue ?? null,
                    "start" => $instance->start ?? null,
                    "start_selling_at_web" =>
                    $instance->startSellingAtWeb ?? null,
                    "stop_selling_at_web" =>
                    $instance->stopSellingAtWeb ?? null,
                    "cancelled" => $instance->cancelled ?? null,

                    "special_event" =>
                    $instance->attribute_CinemaSpecialEvent ?? null,
                    "analogue" => $instance->attribute_Analogue ?? null,
                    "door_time" => $instance->attribute_DoorTime ?? null,
                    "partnership" => $instance->attribute_Partnership ?? null,
                    "external_ticket_link" => $instance->attribute_ExternalTicketLink ?: null,

                    "audio_described" =>
                    $instance->attribute_AudioDescribed ?? null,
                    "captioned" => $instance->attribute_Captioned ?? null,
                    "relaxed" =>
                    $instance->attribute_RelaxedPerformance ?? null,
                    "autism_friendly" => $instance->attribute_AutismFriendlyScreening ?? null,
                    "toddler_friendly" => $instance->attribute_ToddlerFriendlyScreening ?? null,
                    "signed_bsl" => $instance->attribute_SignedBSL ?? null,

                    "free" => $instance->attribute_AffordableTickets === "Free" ? true : false,
                    "pwyc" => $instance->attribute_AffordableTickets === "Pay What You Can" ? true : false,
                ])
            );

            $model->strands()->sync($this->syncMap(
                [$instance->attribute_Strand ?? null, $instance->attribute_Strand2 ?? null],
                $strandIds,
                "strand",
                $instance
            ));

            $model->seasons()->sync($this->syncMap(
                [$instance->attribute_Season ?? null, $instance->attribute_Season2 ?? null],
                $seasonIds,
                "season",
                $instance
            ));
        }

        \App\Models\Instance::withoutGlobalScopes()->whereNotIn('id', Arr::pluck($instances, 'id'))->update(["enabled" => false]);
    }

    /**
     * Build a name→id lookup for a strand/season style model, keyed the way
     * MySQL compares the name column when the rows are upserted: case- and
     * surrounding-whitespace-insensitive. A plain pluck("id", "name") is keyed
     * case-sensitively, so a Spektrix name differing only in casing from the
     * stored row matches on upsert (no new row is made) but then fails to
     * resolve to an id here, and the instance silently loses its strand/season.
     *
     * Where existing rows collide under that key the oldest wins — that's the
     * one editors have been curating in Nova.
     */
    private function nameLookup(string $model): array
    {
        $ids = [];
        foreach ($model::withoutGlobalScopes()->orderBy("id")->pluck("id", "name") as $name => $id) {
            $key = Str::lower(trim($name));
            if ($key !== "" && ! isset($ids[$key])) {
                $ids[$key] = $id;
            }
        }
        return $ids;
    }

    /**
     * Build a belongsToMany sync map [id => ['position' => n]] from an ordered
     * list of names, resolving each against the given name→id lookup. Anything
     * that fails to resolve is logged: the name is the only link between a
     * Spektrix instance and its strand/season, so a silent miss loses content.
     */
    private function syncMap(array $names, array $ids, string $type, $instance): array
    {
        $sync = [];
        foreach ($names as $index => $name) {
            $key = $name ? Str::lower(trim($name)) : null;

            if (! $key) {
                continue;
            }

            if (isset($ids[$key])) {
                $sync[$ids[$key]] = ["position" => $index + 1];
            } else {
                Log::channel("spektrix")->warning(
                    "No {$type} matched \"{$name}\" for instance {$instance->id} (" .
                        ($instance->event->name ?? "unknown event") . ")"
                );
            }
        }
        return $sync;
    }
}
