<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Enums\Fit;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;
    use Sluggable;

    public $incrementing = false;
    protected $keyType = "string";

    protected static function booted()
    {
        static::addGlobalScope("enabled", function (Builder $builder) {
            $builder->where("enabled", true);
        });

        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });
    }

    protected $casts = [
        "content" => \App\Casts\PageContentCast::class,
    ];

    protected $fillable = [
        "enabled",
        "published",
        "slug",
        "id",
        "name",
        "spektrix_name",
        "description",
        "price",
        "postage",
        "type",
        "content",
    ];

    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "name",
            ],
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion("landscape")
            ->quality(80)
            // ->width(1920)
            // ->height(1080)
            ->sharpen(10)
            ->fit(Fit::Crop, 1200, 800)

            ->withResponsiveImages()
            ->performOnCollections("main");

        $this->addMediaConversion("square")
            ->quality(80)
            ->width(1600)
            ->height(1200)
            ->sharpen(10)
            ->fit(Fit::Crop, 1600, 1600)
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

    public function getNameAttribute()
    {
        return $this->getRawOriginal('name') ?? $this->spektrix_name;
    }

    public function getUrlAttribute()
    {
        return route("product.show", ["product" => $this->slug]);
    }

    public function getPriceAttribute($value)
    {
        return "£" . number_format($value, 2);
    }

    public function getPostageAttribute($value)
    {
        return "£" . number_format($value, 2);
    }
}
