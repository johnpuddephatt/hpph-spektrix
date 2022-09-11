<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Fund extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public $incrementing = false;
    protected $keyType = "string";

    protected static function booted()
    {
        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });
    }

    protected $fillable = [
        "published",
        "id",
        "description",
        "name",
        "code",
        "default_donation_amount",
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion("landscape")
            ->quality(80)
            // ->width(1920)
            // ->height(1080)
            ->sharpen(10)
            ->crop("crop-center", 1200, 800)
            ->withResponsiveImages()
            ->performOnCollections("main");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("main")->singleFile(); // used on page hero
    }

    public function featuredImage(): MorphOne
    {
        return $this->morphOne(Media::class, "model")->where(
            "collection_name",
            "=",
            "main"
        );
    }
}
