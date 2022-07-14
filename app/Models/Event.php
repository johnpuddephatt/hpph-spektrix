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
use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Advoor\NovaEditorJs\NovaEditorJsCast;

class Event extends Model implements HasMedia, CachableAttributes
{
    use HasFactory;
    use Sluggable;
    use InteractsWithMedia;
    use CachesAttributes;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = "string";

    protected $casts = [
        "long_description" => NovaEditorJsCast::class,
    ];

    protected $fillable = [
        "published",
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
        "venue",
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
        "live_or_film",
        "certificate_age_guidance",
    ];

    protected $appends = ["has_captioned", "has_audio_described"];

    protected $cachableAttributes = [
        "has_captioned",
        "has_signed_bsl",
        "has_audio_described",
    ];

    protected static function booted()
    {
        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });
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

    public function gallery(): MorphMany
    {
        return $this->morphMany(Media::class, "model")->where(
            "collection_name",
            "=",
            "gallery"
        );
    }

    public function instances()
    {
        return $this->hasMany(\App\Models\Instance::class, "event_id", "id");
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

    // public function getImageAttribute(): array
    // {
    //     return [
    //         "src" => $this->hasMedia("main")
    //             ? $this->getFirstMedia("main")->getUrl("square")
    //             : null,
    //         "srcset" => $this->hasMedia("main")
    //             ? $this->getFirstMedia("main")->getSrcset("square")
    //             : null,
    //     ];
    // }

    // public function getThumbnailAttribute(): ?\Spatie\MediaLibrary\MediaCollections\HtmlableMedia
    // {
    //     return $this->getFirstMedia("main")
    //         ? $this->getFirstMedia("main")("thumb", [
    //             "class" => "",
    //             "loading" => "lazy",
    //         ])
    //         : null;
    // }

    public function getGenresAttribute($value): array
    {
        return $value ? explode(",", $value) : [];
    }

    public function getVibesAttribute($value): array
    {
        return $value ? explode(",", $value) : [];
    }

    public function getFeaturingStarsAttribute($value): array
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

    protected function dateRange(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $dates = explode("-", $attributes["instance_dates"]);
                if (count($dates) == 2 && $dates[0] == $dates[1]) {
                    return $dates[0];
                }
                return $attributes["instance_dates"];
            }
        );
    }
}
