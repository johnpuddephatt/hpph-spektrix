<?php

namespace App\Models;

use App\Casts\PageContentCast;
use App\Nova\Flexible\Layouts\Concerns\HasPageMenuEntry;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasFlexible;
    use LogsActivity;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = ['name', 'template', 'content', 'parent_id', 'slug', 'subtitle', 'introduction', 'display_menu'];

    protected $casts = [
        'content' => PageContentCast::class,
        'display_menu' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('published', true);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name']);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('wide')
            ->quality(80)
            // ->width(1920)
            // ->height(1080)
            ->sharpen(10)
            ->fit(Fit::Crop, 1500, 627)
            ->withResponsiveImages()
            ->performOnCollections('main');

        $this->addMediaConversion('landscape')
            ->quality(80)
            // ->width(1920)
            // ->height(1080)
            ->sharpen(10)
            ->fit(Fit::Crop, 1200, 800)
            ->withResponsiveImages()
            ->performOnCollections('main', 'gallery');

        $this->addMediaConversion('square')
            ->quality(80)
            ->sharpen(10)
            ->fit(Fit::Crop, 1600, 1600)
            ->withResponsiveImages()
            ->performOnCollections('gallery', 'main');

        // Used on sectioned page flexible layout. probably doesn't need to be responsive, switch to regular image field?
        if ($media && Str::startsWith($media->collection_name, 'gallery_')) {
            $this->addMediaConversion('square')
                ->quality(80)
                ->sharpen(10)
                ->fit(Fit::Crop, 1600, 1600)
                ->withResponsiveImages()
                ->performOnCollections($media->collection_name);
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main')->singleFile();
        $this->addMediaCollection('gallery'); // MOVE TO FLEXIBLE
        // $this->addMediaCollection("banner")->singleFile(); // a block with an image background and overlaid text - MOVE TO FLEXIBLE
    }

    public function mainImage(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where(
            'collection_name',
            '=',
            'main'
        );
    }

    public function getURLAttribute()
    {
        $path = '';
        if ($this->parent) {
            $path .= $this->parent->URL;
        }
        if ($this->slug !== '/') {
            $path .= '/';
        }

        return $path .= $this->slug;
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(\App\Models\Page::class, 'parent_id');
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
            ',',
            \App\Models\Page::withoutGlobalScopes()->select('id', 'name', 'parent_id', 'slug')->get()
                ->sortBy('URL')
                ->pluck('id')
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
            $show_all ? config('page-templates') : array_filter(config('page-templates'), function ($item, $key) {
                return ! $item['unique'] || ! \App\Models\Page::where('template', $key)->count();
            }, ARRAY_FILTER_USE_BOTH),
            function ($value) {
                return (new $value['class'])->name();
            }
        );
    }

    /**
     * Memoised for the request: this is called from inside foreach loops in the
     * membership and ticket subscription blocks, where it would otherwise issue
     * one query per card. Null results are cached too, so a missing template page
     * doesn't re-query on every call.
     */
    protected static array $templateUrls = [];

    public static function getTemplateUrl($template)
    {
        return static::$templateUrls[$template] ??=
            \App\Models\Page::firstWhere('template', $template)?->url;
    }

    /**
     * The sections listed in the page's "on this page" menu: every content
     * block that can label itself (see HasPageMenuEntry), in page order.
     */
    public function menuLinks()
    {
        if (! $this->display_menu || ! $this->content) {
            return collect();
        }

        return collect($this->content)
            ->filter(fn ($layout) => $layout instanceof HasPageMenuEntry && filled($layout->menuLabel()))
            ->values();
    }

    public function resolveContent()
    {
        $this->content = (new (config('page-templates')[$this->template]['class']
        ))->resolve($this);

        return $this;
    }
}
