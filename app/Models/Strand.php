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
use Illuminate\Database\Eloquent\Relations\HasMany;

use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Advoor\NovaEditorJs\NovaEditorJsCast;
use App\Casts\PageContentCast;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Strand extends Model implements HasMedia, CachableAttributes, Sortable
{
    use HasFactory;
    use Sluggable;
    use InteractsWithMedia;
    use CachesAttributes;
    use SoftDeletes;
    use SortableTrait;


    public $timestamps = false;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        "name",
        "slug",
        "short_description",
        "description",
        "color",
        "logo",
        "logo_simple",
        "content",
        "enabled",
        "published",
        "show_on_event_card",
        "show_on_instance_card",
        "show_in_booking_path",
        "additional_description",
        "funders_logo",
        'display_type',
        'sort_order',
        'show_in_programme'
    ];

    protected $casts = [
        "content" => PageContentCast::class,
        "enabled" => "boolean",
        "published" => "boolean",
        "show_on_event_card" => "boolean",
        "show_on_instance_card" => "boolean",
        "show_in_booking_path" => "boolean",
        "show_in_programme" => "boolean",
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

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('sort_order', 'asc');
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

    public function instances(): HasMany
    {
        return $this->hasMany(Instance::class, "strand_name", "name")->whereHas(
            "event",
            function ($event) {
                return $event->shownInProgramme();
            }
        );
    }

    public function allFutureInstances(): HasMany
    {
        return $this->hasMany(Instance::class)->withoutGlobalScope('not_coming_soon')->whereHas(
            "event",
            function ($event) {
                return $event->shownInProgramme();
            }
        );
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function getLatestPostAttribute()
    {
        return $this->posts->first();
    }

    public function scopeShowInProgramme(Builder $query)
    {
        return $query->where("show_in_programme", true);
    }

    public function getUrlAttribute()
    {
        return route("strand.show", $this->slug);
    }
}
