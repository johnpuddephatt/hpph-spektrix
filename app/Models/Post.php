<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;
use Advoor\NovaEditorJs\NovaEditorJsCast;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;
    use HasTags;

    protected $fillable = ["title", "introduction", "content", "slug"];

    protected $casts = [
        "created_at" => "date",
        "content" => NovaEditorJsCast::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(["title"]);
    }

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

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Event::class);
    }

    public function getIntroductionAttribute($value)
    {
        return $value ?:
            substr(
                strip_tags(
                    \Advoor\NovaEditorJs\NovaEditorJs::generateHtmlOutput(
                        $this->content
                    )
                ),
                0,
                100
            );
    }
}
