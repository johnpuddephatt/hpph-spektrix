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
use App\Casts\PageContentCast;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Cache;
use Spatie\Image\Enums\CropPosition;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasFlexible;
    use LogsActivity;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = ["name", "template", "content", "parent_id", "slug", "subtitle", "introduction"];

    protected $casts = [
        "content" => PageContentCast::class,
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

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion("wide")
            ->quality(80)
            // ->width(1920)
            // ->height(1080)
            ->sharpen(10)
            ->crop(1500, 627, CropPosition::Center)
            ->withResponsiveImages()
            ->performOnCollections("main");

        $this->addMediaConversion("landscape")
            ->quality(80)
            // ->width(1920)
            // ->height(1080)
            ->sharpen(10)
            ->crop(1200, 800, CropPosition::Center)
            ->withResponsiveImages()
            ->performOnCollections("main", "gallery");


        $this->addMediaConversion("square")
            ->quality(80)
            ->sharpen(10)
            ->crop(1600, 1600, CropPosition::Center)
            ->withResponsiveImages()
            ->performOnCollections("gallery", "main");

        // Used on sectioned page flexible layout. probably doesn't need to be responsive, switch to regular image field? 
        if ($media && Str::startsWith($media->collection_name, "gallery_")) {
            $this->addMediaConversion("square")
                ->quality(80)
                ->sharpen(10)
                ->crop(1600, 1600, CropPosition::Center)
                ->withResponsiveImages()
                ->performOnCollections($media->collection_name);
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("main")->singleFile();
        $this->addMediaCollection("gallery"); // MOVE TO FLEXIBLE
        // $this->addMediaCollection("banner")->singleFile(); // a block with an image background and overlaid text - MOVE TO FLEXIBLE

    }

    public function mainImage(): MorphOne
    {
        return $this->morphOne(Media::class, "model")->where(
            "collection_name",
            "=",
            "main"
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
            \App\Models\Page::withoutGlobalScopes()->select("id", "name", "parent_id", "slug")->get()
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

    public static function getAvailableTemplates($show_all)
    {
        return Arr::map(
            $show_all ? config("page-templates") : array_filter(config("page-templates"), function ($item, $key) {
                return !$item['unique'] || !\App\Models\Page::where('template', $key)->count();
            }, ARRAY_FILTER_USE_BOTH),
            function ($value) {
                return (new $value['class'])->name();
            }
        );
    }

    public static function getTemplateUrl($template)
    {
        return \App\Models\Page::firstWhere('template', $template)?->url;
    }

    public function resolveContent()
    {

        $this->content = (new (config("page-templates")[$this->template]["class"]
        ))->resolve($this);

        return $this;
    }
}
