<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Spatie\MediaLibrary\InteractsWithMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;
use App\Casts\PageCast;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasFlexible;
    use LogsActivity;

    protected $fillable = ["title", "content", "slug", "parent_page_id"];

    protected $casts = [
        "content" => PageCast::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(["title"]);
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

    protected static function booted()
    {
        static::creating(function ($post) {
            if ($post->title !== "Home" && !isset($post->slug)) {
                $post->slug = Str::slug($post->title, "-");
            }
        });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        if ($media && Str::startsWith($media->collection_name, "gallery_")) {
            $this->addMediaConversion("portrait")
                ->quality(80)
                ->sharpen(10)
                ->crop("crop-center", 1360, 1600)
                ->withResponsiveImages()
                ->performOnCollections($media->collection_name);
        }

        if ($media && Str::startsWith($media->collection_name, "banner_")) {
            $this->addMediaConversion("landscape")
                ->quality(80)
                ->sharpen(10)
                ->crop("crop-center", 1600, 1360)
                ->withResponsiveImages()
                ->performOnCollections($media->collection_name);
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("gallery");
        $this->addMediaCollection("banner")->singleFile();
    }

    public function getURLAttribute()
    {
        $path = "";
        if ($this->parent_page) {
            $path .= $this->parent_page->URL;
        }
        if ($this->slug !== "/") {
            $path .= "/";
        }
        return $path .= $this->slug;
    }

    public function parent_page()
    {
        return $this->belongsTo(\App\Models\Page::class, "parent_page_id");
    }

    public function child_pages()
    {
        return $this->hasMany(\App\Models\Page::class, "parent_page_id");
    }

    public function indented_title()
    {
        if ($this->parent_page) {
            if ($this->parent_page->parent_page) {
                return "&nbsp;&mdash;&mdash;&mdash;&mdash;&nbsp;&nbsp;&nbsp;{$this->title}";
            } else {
                return "&nbsp;&mdash;&mdash;&nbsp;&nbsp;&nbsp;{$this->title}";
            }
        } else {
            return $this->title;
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
}
