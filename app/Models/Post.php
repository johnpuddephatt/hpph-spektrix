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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;
use Advoor\NovaEditorJs\NovaEditorJsCast;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;
    use HasTags;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        "title",
        "introduction",
        "featured",
        "published",
        "content",
        "slug",
    ];

    protected $casts = [
        "created_at" => "date",
        "featured" => "boolean",
        "published" => "boolean",
        // "content" => NovaEditorJsCast::class,
    ];

    protected static function booted()
    {
        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });
    }

    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "title",
            ],
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(["title"]);
    }

    // protected $appends = ["image"];

    // protected static function booted()
    // {
    //     static::creating(function ($post) {
    //         $post->slug = Str::slug($post->title, "-");
    //     });
    // }

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

    public function getUrlAttribute()
    {
        return route("post.show", ["post" => $this->slug]);
    }

    public function relatedPosts($number)
    {
        $related = Post::withAnyTags($this->tags)
            ->latest()
            ->whereNot("id", $this->id)
            ->take($number)
            ->get();
        if ($related->count() < $number) {
            return $related->merge(
                Post::latest()
                    ->whereNotIn(
                        "id",
                        $related->pluck("id")->toArray() + [$this->id]
                    )
                    ->take($number - $related->count())
                    ->get()
            );
        } else {
            return $related;
        }
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
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
