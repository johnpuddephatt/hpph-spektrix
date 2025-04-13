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
use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements HasMedia, CachableAttributes
{
    use CachesAttributes;

    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;
    use HasTags;
    use Sluggable;
    use SoftDeletes;

    protected $dateOutputFormat = "d M Y";

    protected $fillable = [
        "title",
        "introduction",
        "featured",
        "published",
        "content",
        "slug",
        "subtitle",
    ];

    protected $casts = [
        "created_at" => "date",
        "featured" => "boolean",
        "published" => "boolean",
        "content" => NovaEditorJsCast::class,
    ];

    protected $appends = ["url", "date"];
    protected $with = ["featuredImage"];

    protected static function booted()
    {
        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });

        static::saving(function ($post) {
            if ($post->content == null) {
                $post->content =
                    '{"time":1684240144151,"blocks":[],"version":"2.25.0"}';
            }
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("main")->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion("wide")
            ->quality(80)
            ->sharpen(10)
            ->crop("crop-center", 1500, 627)
            ->withResponsiveImages()
            ->performOnCollections("main");

        $this->addMediaConversion("landscape")
            ->quality(80)
            ->sharpen(10)
            ->crop("crop-center", 1200, 800)
            ->withResponsiveImages()
            ->performOnCollections("main");

        $this->addMediaConversion("square")
            ->quality(80)
            ->sharpen(10)
            ->crop("crop-center", 800, 800)
            ->withResponsiveImages()
            ->performOnCollections("main");
    }

    public function getDateAttribute()
    {
        return $this->created_at
            ? $this->created_at->format($this->dateOutputFormat)
            : null;
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

    public function getTagsTranslatedAttribute()
    {
        return $this->remember("tags_translated", 3600, function () {
            return $this->tagsTranslated()->get();
        });
    }

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

    public function strands(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Strand::class);
    }

    public function seasons(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Season::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
