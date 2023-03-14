<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Season extends Model implements HasMedia, CachableAttributes
{
    use HasFactory;
    use Sluggable;
    use InteractsWithMedia;
    use CachesAttributes;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "slug",
        "short_description",
        "description",
        "logo",
        "content",
        "enabled",
        "published",
    ];

    protected $casts = [
        "content" => PageContentCast::class,
        "enabled" => "boolean",
        "published" => "boolean",
    ];

    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "name",
            ],
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });

        // static::addGlobalScope("enabled", function (Builder $builder) {
        //     $builder->where("enabled", true);
        // });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion("landscape")
            ->quality(80)
            ->crop("crop-center", 2000, 1200)
            ->sharpen(10)
            ->format("jpg")
            ->withResponsiveImages()
            ->performOnCollections("main");

        $this->addMediaConversion("thumb")
            ->width(800)
            ->height(600)
            ->extractVideoFrameAtSecond(1)
            ->performOnCollections("video");

        $this->addMediaConversion("wide")
            ->quality(80)
            ->crop("crop-center", 1500, 627)
            ->sharpen(10)
            ->format("jpg")
            ->withResponsiveImages()
            ->performOnCollections("main");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("video")->singleFile();
        $this->addMediaCollection("main")->singleFile();
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

    public function instances()
    {
        return $this->hasMany(Instance::class, "season_name", "name");
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function getLatestPostAttribute()
    {
        return $this->posts->first();
    }

    public function getUrlAttribute()
    {
        return route("season.show", $this->slug);
    }
}
