<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Arr;

use Spatie\MediaLibrary\InteractsWithMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;
use App\Casts\PageCast;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Cache;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasFlexible;
    use LogsActivity;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = ["name", "template", "content", "parent_id", "slug", "introduction"];

    protected $casts = [
        "content" => "object",
    ];

    protected static function booted()
    {
        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(["name"]);
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion("wide")
            ->quality(80)
            // ->width(1920)
            // ->height(1080)
            ->sharpen(10)
            ->crop("crop-center", 1500, 627)
            ->withResponsiveImages()
            ->performOnCollections("main", "secondary");

        $this->addMediaConversion("landscape")
            ->quality(80)
            // ->width(1920)
            // ->height(1080)
            ->sharpen(10)
            ->crop("crop-center", 1200, 800)
            ->withResponsiveImages()
            ->performOnCollections("main", "banner", "gallery", "secondary");

        $this->addMediaConversion("portrait")
            ->quality(80)
            ->sharpen(10)
            ->crop("crop-center", 1360, 1600)
            ->withResponsiveImages()
            ->performOnCollections("gallery");

        // if ($media && Str::startsWith($media->collection_name, "gallery_")) {
        //     $this->addMediaConversion("portrait")
        //         ->quality(80)
        //         ->sharpen(10)
        //         ->crop("crop-center", 1360, 1600)
        //         ->withResponsiveImages()
        //         ->performOnCollections($media->collection_name);
        // }

        if ($media && Str::startsWith($media->collection_name, "banner_")) {
            $this->addMediaConversion("landscape")
                ->quality(80)
                ->sharpen(10)
                ->crop("crop-center", 1600, 900)
                ->withResponsiveImages()
                ->performOnCollections($media->collection_name);
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("main")->singleFile();
        $this->addMediaCollection("secondary")->singleFile();
        $this->addMediaCollection("gallery");

        $this->addMediaCollection("banner")->singleFile(); // a block with an image background and overlaid text
        
    }

    public function mainImage(): MorphOne
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

    public function getURLAttribute()
    {
        $path = "";
        if ($this->parent) {
            $path .= $this->parent->URL;
        }
        if ($this->slug !== "/") {
            $path .= "/";
        }
        return $path .= $this->slug;
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Page::class, "parent_id");
    }

    public function children()
    {
        return $this->hasMany(\App\Models\Page::class, "parent_id");
    }

    public function indented_name()
    {
        if ($this->parent) {
            if ($this->parent->parent) {
                return "&nbsp;&mdash;&mdash;&mdash;&mdash;&nbsp;&nbsp;&nbsp;{$this->name}";
            } else {
                return "&nbsp;&mdash;&mdash;&nbsp;&nbsp;&nbsp;{$this->name}";
            }
        } else {
            return $this->name;
        }
    }

    public function scopeOrderPagesByUrl($query)
    {
        $ids_ordered = implode(
            ",",
            \App\Models\Page::all()
                ->sortBy("URL")
                ->pluck("id")
                ->toArray()
        );
        if ($ids_ordered) {
            $query->getQuery()->orders = [];
            $query->orderByRaw("FIELD(id, $ids_ordered)");
        }
        return $query;
    }

    public static function getAvailableTemplates($resource_id) {
        return Arr::map(
            $resource_id ? config("page-templates") : array_filter(config("page-templates"), function($item, $key) {
                return !$item['unique'] || !\App\Models\Page::where('template', $key)->count();
            }, ARRAY_FILTER_USE_BOTH),
            function($value) {
                return (new $value['class'])->name();
            }
        );
    }

    public function resolveContent() {

        $this->content = (new (config("page-templates")[$this->template][
                    "class"
                ]
                ))->resolve($this);

        return $this;
    }

    public function getHomeJournalPostsAttribute()
    {
        return Cache::remember("home_posts", 3600, function () {
            return \App\Models\Post::with("mainImage")
                ->latest()
                ->take(3)
                ->get();
        });
    }
}
