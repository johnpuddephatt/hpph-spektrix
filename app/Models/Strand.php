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
use Illuminate\Database\Eloquent\SoftDeletes;

class Strand extends Model implements HasMedia, CachableAttributes
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
        "content" => "object",
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

        static::addGlobalScope("enabled", function (Builder $builder) {
            $builder->where("enabled", true);
        });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion("landscape")
            ->quality(80)
            ->crop("crop-center", 2000, 1200)
            ->sharpen(10)
            ->format("jpg")
            ->withResponsiveImages()
            ->performOnCollections(
                "main",
                "content->more_information->image",
                "content->members_voices->image"
            );
        $this->addMediaConversion("wide")
            ->quality(80)
            ->crop("crop-center", 1500, 627)
            ->sharpen(10)
            ->format("jpg")
            ->withResponsiveImages()
            ->performOnCollections("main", "secondary");
        $this->addMediaConversion("square")
            ->quality(80)
            ->crop("crop-center", 1200, 1200)
            ->sharpen(10)
            ->format("jpg")
            ->withResponsiveImages()
            ->performOnCollections("content->more_information->image");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("main")->singleFile();
        $this->addMediaCollection("secondary")->singleFile();
        $this->addMediaCollection(
            "content->members_voices->image"
        )->singleFile();
        $this->addMediaCollection(
            "content->more_information->image"
        )->singleFile();
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

    public function instances()
    {
        return $this->hasMany(Instance::class, "strand_name", "name");
    }

    public function logo(): Attribute
    {
        return Attribute::make(
            get: fn($value) => str_replace(
                "<svg",
                '<svg class="w-full h-auto"',
                $value
            )
        );
    }
}
