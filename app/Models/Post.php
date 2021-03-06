<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ["title", "content", "slug"];

    protected $casts = [
        "created_at" => "date:d M",
    ];

    // protected $appends = ["image"];

    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title, "-");
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("main")->singleFile();
    }

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

    // public function getImageAttribute(): array
    // {
    //     return [
    //         "src" => $this->getFirstMedia("main")->getUrl("landscape"),
    //         "srcset" => $this->getFirstMedia("main")->getSrcset("landscape"),
    //     ];
    // }

    public function featuredImage(): MorphOne
    {
        return $this->morphOne(Media::class, "model")->where(
            "collection_name",
            "=",
            "main"
        );
    }
}
