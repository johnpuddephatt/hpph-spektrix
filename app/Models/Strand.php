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

use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;

class Strand extends Model implements HasMedia, CachableAttributes
{
    use HasFactory;
    use Sluggable;
    use InteractsWithMedia;
    use CachesAttributes;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "slug",
        "short_description",
        "description",
        "logo",
    ];

    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "name",
            ],
        ];
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion("landscape")
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
    }

    public function featuredImage(): MorphOne
    {
        return $this->morphOne(Media::class, "model")->where(
            "collection_name",
            "=",
            "main"
        );
    }

    public function instances()
    {
        return $this->hasMany(Instance::class, "strand_name", "name");
    }
}
