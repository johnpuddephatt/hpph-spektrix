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
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    ];

    protected static function booted()
    {
        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });

        static::addGlobalScope("enabled", function (Builder $builder) {
            $builder->where("enabled", true);
        });
    }

    protected $fillable = [
        "published",
        "enabled",
        "id",
        "description",
        "long_description",
        "duration",
        "is_on_sale",
        "name",
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
        "year_of_production",
        "featuring_stars",
        "genres",
        "vibes",
        "members_offer_available",
        "certificate_age_guidance",
    ];

    protected $appends = [
        "has_captioned",
        "has_audio_described",
        "genres_and_vibes",
    ];

    protected $cachableAttributes = [
        "has_captioned",
        "has_signed_bsl",
        "has_audio_described",
    ];

    public function scopeUnpublished($query)
    {
        return $query
            ->withoutGlobalScope("published")
            ->where("published", false);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(["name"]);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion("square")
            ->quality(80)
            ->width(1360)
            ->height(1600)
            ->sharpen(10)
            ->crop("crop-center", 1360, 1600)
            ->withResponsiveImages()
            ->performOnCollections("main", "secondary");

        $this->addMediaConversion("wide")
            ->quality(80)
            ->crop("crop-center", 2000, 1200)
            ->sharpen(10)
            ->format("webp")
            ->withResponsiveImages()
            ->performOnCollections("main", "secondary");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("main")->singleFile(); // used on page hero
        $this->addMediaCollection("secondary")->singleFile(); // used as thumbnail and lower down on page
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

    public function secondaryImage(): MorphOne
    {
        return $this->morphOne(Media::class, "model")->where(
            "collection_name",
            "=",
            "secondary"
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

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function instances(): HasMany
    {
        return $this->hasMany(Instance::class);
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

    public function getHasAudioDescribedAttribute(): bool
    {
        return $this->remember("has_audio_described", 3600, function (): bool {
            return !!$this->instances()
                ->audioDescribed()
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

    public function getInstanceDatesAttribute($value): string
    {
        $parts = explode("-", $value);
        if ($parts[0] == $parts[1]) {
            return $parts[0];
        } else {
            return str_replace("-", " – ", $value);
        }
    }

    public function getStrandsAttribute($value)
    {
        return $this->remember("strand", 3600, function () {
            return $this->instances
                ->pluck("strand")
                ->unique()
                ->flatten()
                ->filter();
        });
    }

    public function getUrlAttribute()
    {
        return route("event.show", ["event" => $this->slug]);
    }

    public function getVenueAttribute()
    {
        if (!$this->instances->count()) {
            return null;
        }
        return $this->instances
            ->pluck("venue")
            ->unique()
            ->count() > 1
            ? "Multiple venues"
            : $this->instances->first()->venue;
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

    // public function getGenresAttribute($value): array
    // {
    //     return $value ? explode(",", $value) : [];
    // }

    // public function getVibesAttribute($value): array
    // {
    //     return $value ? explode(",", $value) : [];
    // }

    public function getFeaturingStarsAttribute($value): array
    {
        return $value ? explode(",", $value) : [];
    }

    public function getCountryOfOriginAttribute($value): array
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

    public function todayInstances()
    {
        return $this->instances()->today();
    }

    public function tomorrowInstances()
    {
        return $this->instances()->tomorrow();
    }
}
