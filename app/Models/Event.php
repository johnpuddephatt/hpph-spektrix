<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Advoor\NovaEditorJs\NovaEditorJsCast;
use Carbon\Carbon;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cohensive\OEmbed\Facades\OEmbed;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Event extends Model implements HasMedia, CachableAttributes
{
    use HasFactory;
    use Sluggable;
    use InteractsWithMedia;
    use CachesAttributes;
    use LogsActivity;
    use SoftDeletes;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = "string";

    protected $casts = [
        "enabled" => "boolean",
        "published" => "boolean",
        "long_description" => NovaEditorJsCast::class,
        "reviews" => FlexibleCast::class,
        "why_watch" => "object",
        "last_instance_date_time" => "datetime",
    ];

    protected static function booted()
    {
        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });

        // static::addGlobalScope("enabled", function (Builder $builder) {
        //     $builder->where("enabled", true);
        // });
    }

    protected $fillable = [
        "published",
        "enabled",
        "id",
        "description",
        "long_description",
        "reviews",
        "why_watch",
        "duration",
        "is_on_sale",
        "name",
        "subtitle",
        "instance_dates",
        "first_instance_date_time",
        "last_instance_date_time",
        "alternative_content",
        "archive_film",
        "audio_description",
        "mubigo",
        "non_specialist_film",
        "country_of_origin",
        "director",
        "distributor",
        "f_rating",
        "language",
        "original_language_title",
        "strobe_light_warning",
        "content_guidance",
        "year_of_production",
        "featuring_stars",
        "genres",
        "vibes",
        "members_offer_available",
        "certificate_age_guidance",
        "trailer",
        "coming_soon",
        "external_booking_link",
        "related_event_id"
    ];

    protected $appends = [
        "date_range",
        "has_captioned",
        "has_signed_bsl",
        "has_relaxed",
        "has_autism_friendly",
        "has_toddler_friendly",
        "genres_and_vibes",
    ];

    protected $cachableAttributes = [
        "has_captioned",
        "has_signed_bsl",
        "has_relaxed",
        "has_autism_friendly",
        "has_toddler_friendly"
    ];

    public function scopeUnpublished($query)
    {
        return $query
            ->withoutGlobalScope("published")
            ->where("published", false);
    }

    public function scopeHasFutureOrRecentInstances(Builder $query)
    {
        return $query->where(
            "last_instance_date_time",
            ">",
            Carbon::now()->subDays(30)
        )->orWhereNotNull('coming_soon');
    }

    public function scopeHasFutureInstances(Builder $query)
    {
        return $query->where(
            "last_instance_date_time",
            ">",
            Carbon::now()->subMinutes(60)
        )->orWhereNotNull('coming_soon');
    }

    public function scopeAudioDescribed($query)
    {
        return $query->where("audio_description", true);
    }

    public function scopeShownInProgramme($query)
    {
        return $query->where("show_in_programme", true);
    }

    public static function getEventsForSlider($type, $name, $exclude = [])
    {
        // $events =
        //     Event::shownInProgramme()->whereHas('allFutureInstances', function (Builder $query) use ($name, $type) {
        //         $query->where($type . '_name', $name);
        //     })
        //     ->whereNotIn('id', $exclude)
        //     ->get()

        //     ->sortBy([
        //         fn($a, $b) => $a->allFutureInstances()->orderBy('start')->first()->start->timestamp - $b->allFutureInstances()->orderBy('start')->first()->start->timestamp
        //         // fn($a) => $a->coming_soon ? 1 : 0
        //     ]);
        // echo '<table>';
        // foreach ($events as $event) {
        //     echo '<tr><td> ' . $event->name . '</td><td>' . $event->date_range .  '</td><td>' . $event->allFutureInstances()->orderBy('start')->first()->start->format('jS F Y')  . ':::' .  $event->allFutureInstances()->orderBy('start')->first()->start->timestamp  . "</td></tr>";
        // }
        // echo '</table>';
        // die();


        return Event::shownInProgramme()->whereHas('allFutureInstances', function (Builder $query) use ($name, $type) {
            $query->where($type . '_name', $name);
        })
            ->whereNotIn('id', $exclude)
            ->get()

            ->sortBy([
                'coming_soon',
                fn($a, $b) => $a->allFutureInstances()->orderBy('start')->first()->start->timestamp - $b->allFutureInstances()->orderBy('start')->first()->start->timestamp,
                // fn($a) => $a->coming_soon ? 0 : -1,
            ]);
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(["name"]);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion("thumb")
            ->width(1920)
            ->height(1080)
            ->crop("crop-center", 1920, 1080)
            ->extractVideoFrameAtSecond(0);
        // ->performOnCollections("video");

        $this->addMediaConversion("square")
            ->quality(80)
            ->width(1360)
            ->height(1600)
            ->sharpen(10)
            ->crop("crop-center", 1360, 1600)
            ->withResponsiveImages()
            ->performOnCollections("main");

        $this->addMediaConversion("wide")
            ->quality(80)
            ->crop("crop-center", 2000, 1200)
            ->sharpen(10)
            ->format("webp")
            ->withResponsiveImages()
            ->performOnCollections("main");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("video")->singleFile();
        $this->addMediaCollection("main")->singleFile();
        $this->addMediaCollection("gallery");
    }

    public function featuredImage(): MorphOne
    {
        return $this->morphOne(Media::class, "model")->where(
            "collection_name",
            "=",
            "main"
        );
    }

    public function featuredVideo(): MorphOne
    {
        return $this->morphOne(Media::class, "model")->where(
            "collection_name",
            "=",
            "video"
        );
    }

    public function gallery(): MorphMany
    {
        return $this->morphMany(Media::class, "model")->where(
            "collection_name",
            "=",
            "gallery"
        );
    }

    public function latest_post()
    {
        return $this->posts()
            ->latest()
            ->limit(1);
    }

    public function related_event(): BelongsTo
    {
        return $this->belongsTo(Event::class, "related_event_id");
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function instances(): HasMany
    {
        return $this->hasMany(Instance::class)->withoutGlobalScope("has_event");
    }

    public function pastAndFutureInstances(): HasMany
    {
        return $this->hasMany(Instance::class)->withoutGlobalScopes([
            "has_event",
            "has_future_instances",
        ]);
    }


    public function allInstances(): HasMany
    {
        return $this->hasMany(Instance::class)->withoutGlobalScopes();
    }

    public function allFutureInstances(): HasMany
    {
        return $this->hasMany(Instance::class)->withoutGlobalScope('not_coming_soon');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "name",
            ],
        ];
    }

    public function getHasCaptionedAttribute(): bool
    {
        return $this->remember("has_captioned", 3600, function (): bool {
            return !!$this->instances()
                ->captioned()
                ->count();
        });
    }

    public function getHasSignedBslAttribute(): bool
    {
        return $this->remember("has_signed_bsl", 3600, function (): bool {
            return !!$this->instances()
                ->signedBsl()
                ->count();
        });
    }

    public function getHasRelaxedAttribute(): bool
    {
        return $this->remember("has_relaxed", 3600, function (): bool {
            return !!$this->instances()
                ->relaxed()
                ->count();
        });
    }

    public function getHasAutismFriendlyAttribute(): bool
    {
        return $this->remember("has_autism_friendly", 3600, function (): bool {
            return !!$this->instances()
                ->autismFriendly()
                ->count();
        });
    }

    public function getHasToddlerFriendlyAttribute(): bool
    {
        return $this->remember("has_toddler_friendly", 3600, function (): bool {
            return !!$this->instances()
                ->toddlerFriendly()
                ->count();
        });
    }
    // public function getHasSpecialEventAttribute()
    // {
    //     return $this->remember("has_special_event", 3600, function () {
    //         return $this->instances()

    //             ->pluck("special_event")
    //             ->unique()
    //             ->first();
    //     });
    // }

    public function getTrailerEmbedAttribute(): array
    {
        return $this->remember("trailer", 3600, function (): array {
            if ($this->trailer) {
                $trailerEmbed = OEmbed::get($this->trailer);
                if ($trailerEmbed) {
                    return [
                        "html" => $trailerEmbed->html([
                            "class" => "absolute inset-0 w-full h-full",
                            "autoplay" => 1,
                        ]),
                        "ratio" => isset($trailerEmbed->data()["height"])
                            ? ($trailerEmbed->data()["height"] /
                                $trailerEmbed->data()["width"]) *
                            100
                            : 56.25,
                    ];
                } else {
                    return [];
                }
            } else {
                return [];
            }
        });
    }

    // public function getInstanceDatesAttribute($value): string
    // {
    //     $parts = explode("-", $value);
    //     if ($parts[0] == $parts[1]) {
    //         return $parts[0];
    //     } else {
    //         return str_replace("-", " – ", $value);
    //     }
    // }

    public function getSpektrixApiLinkAttribute(): string
    {
        return 'https://system.spektrix.com/' . nova_get_setting('spektrix_client_name') .  '/api/v3/events/' . $this->id;
    }

    public function getStrandAttribute($value)
    {
        return $this->remember("strand", 3600, function () {
            $strand = $this->allFutureInstances
                ->pluck("strand")
                ->unique()
                ->flatten()
                ->filter()
                ->first();

            return $strand;
        });
    }

    public function getSeasonAttribute($value)
    {
        return $this->remember("season", 3600, function () {
            $season = $this->allFutureInstances
                ->pluck("season")
                ->unique()
                ->flatten()
                ->filter()
                ->first();

            return $season;
        });
    }

    public function getDateRangeAttribute()
    {
        return $this->remember("dateRange", 3600, function () {
            if ($this->coming_soon) {
                return 'Coming soon • ' . $this->coming_soon;
            } elseif ($this->instances->count() == 0) {
                return "";
            } else {
                $dates = $this->instances->pluck("start_date")->unique();

                if ($dates->count() == 1) {

                    return $dates->first() .
                        " &middot; " . $this->instances->pluck('start_time')->implode(' &amp; ');
                } else {
                    return $dates->first() . " – " . $dates->last();
                }
            }
        });
    }

    public function getUrlAttribute()
    {
        return route("event.show", ["event" => $this->slug]);
    }

    // public function getVenueAttribute()
    // {
    //     return $this->remember("venue", 3600, function () {
    //         if (!$this->instances->count()) {
    //             return null;
    //         }
    //         return $this->instances
    //             ->pluck("venue")
    //             ->unique()
    //             ->count() > 1
    //             ? "Multiple venues"
    //             : $this->instances->first()->venue;
    //     });
    // }

    public function getFormatAttribute()
    {
        return $this->remember("format", 3600, function () {
            if (!$this->instances->count()) {
                return null;
            }
            return $this->instances
                ->pluck("analogue")
                ->unique()
                ->count() > 1
                ? "Showing in multiple formats"
                : ($this->instances->first()->analogue ?:
                    null);
        });
    }

    public function getLanguageAttribute($value): array
    {
        return $value ? explode(",", $value) : [];
    }

    public function getGenresAndVibesAttribute(): array
    {
        $genres = $this->genres ? explode(",", $this->genres) : [];
        $vibes = $this->vibes ? explode(",", $this->vibes) : [];

        return array_merge(array_slice($genres, 0, 1), $vibes);
    }

    public function getFeaturingStarsAttribute($value): array
    {
        return $value ? explode(",", $value) : [];
    }

    public function getCountryOfOriginAttribute($value): array
    {
        return $value ? explode(",", $value) : [];
    }

    public function getContentGuidanceAttribute($value): array
    {
        return $value ? explode(",", $value) : [];
    }

    public function getDurationAttribute($value): string
    {
        return Str::of(
            \Carbon\CarbonInterval::seconds($value * 60)
                ->cascade()
                ->forHumans()
        )
            ->replace(" hour", "hr")
            ->replace(" minute", "min");
    }


    // public function todayInstances()
    // {
    //     return $this->instances()->today();
    // }

    // public function tomorrowInstances()
    // {
    //     return $this->instances()->tomorrow();
    // }

    // public function thisWeekInstances()
    // {
    //     return $this->instances()->thisWeek();
    // }
}
