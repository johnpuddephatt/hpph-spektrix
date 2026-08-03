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
use App\Casts\PageContentCast;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Enums\Fit;

class Season extends Model implements HasMedia, CachableAttributes, Sortable
{
    use HasFactory;
    use Sluggable;
    use InteractsWithMedia;
    use CachesAttributes;
    use SoftDeletes;
    use SortableTrait;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "slug",
        'hpph_presents',
        "short_description",
        "description",
        "logo",
        "content",
        "enabled",
        "force_enabled_until",
        "published",
        "additional_description",
        "funders_logo",
        'display_type',
        'sort_order',
        'show_in_programme',
        'show_header',
        'hero_overlay_image',
    ];

    protected $casts = [
        "content" => PageContentCast::class,
        "enabled" => "boolean",
        "published" => "boolean",
        "hpph_presents" => "boolean",
        "force_enabled_until" => "datetime",
        "show_in_programme" => "boolean",
        "show_header" => "boolean",
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
        // The public season menu and homepage carousel read this list in
        // descending order, so Nova has to drag in the same direction —
        // otherwise dragging a season to the top sends it to the bottom of
        // the site.
        'nova_order_by' => 'desc',
    ];

    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "name",
            ],
        ];
    }

    /**
     * Sortable works out the next `sort_order` from max() over this query. The
     * default is `static::query()`, which still carries the published/enabled
     * global scopes — so an import that creates a season while nothing matching
     * is published gets max() = null and every new season lands on 1.
     */
    public function buildSortQuery(): Builder
    {
        return static::query()->withoutGlobalScopes();
    }

    protected static function booted()
    {
        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });

        static::addGlobalScope("enabled", function (Builder $builder) {
            $builder->where(function (Builder $query) {
                $query
                    ->where("enabled", true)
                    ->orWhere("force_enabled_until", ">=", now());
            });
        });

        static::addGlobalScope("order", function (Builder $builder) {
            $builder->orderBy("sort_order", "desc");
        });
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion("landscape")
            ->quality(80)
            ->fit(Fit::Crop, 2000, 1200)
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
            ->fit(Fit::Crop, 1500, 627)
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

    public function getDateRangeAttribute()
    {
        $dates = $this->belongsToMany(Instance::class)->orderBy('start')
            ->pluck("start");

        if ($dates->isEmpty()) {
            return 'Coming soon';
        } elseif ($dates->count() == 1) {
            return $dates->first()->format("d M Y");
        } else {
            return $dates->first()->format("d M Y") . ' - ' . $dates->last()->format("d M Y");
        }
        // return $instances;
        // return [];
    }

    public function instances(): BelongsToMany
    {
        return $this->belongsToMany(Instance::class)->whereHas(
            "event",
            function ($event) {
                return $event->shownInProgramme();
            }
        );
    }

    /**
     * Every attached screening, past and cancelled ones included. `instances()`
     * only ever returns future, on-sale screenings, so it can't be used to work
     * out when a season actually ran.
     */
    public function allInstances(): BelongsToMany
    {
        return $this->belongsToMany(Instance::class)->withoutGlobalScopes();
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
        return route("season.show", $this->slug);
    }
}
