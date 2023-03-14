<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Advoor\NovaEditorJs\NovaEditorJsCast;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Opportunity extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        "title",
        "slug",
        "type",
        "hours",
        "application_deadline",
        "salary",
        "responsible_to",
        "probation_period",
        "notice_period",
        "holidays",
        "summary",
        "content",
        "published",
        "application_form",
    ];

    protected $casts = [
        "published" => "boolean",
        "content" => NovaEditorJsCast::class,
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

    public function getUrlAttribute()
    {
        return route("opportunity.show", ["opportunity" => $this->slug]);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion("portrait")
            ->quality(80)
            ->width(1600)
            ->height(1200)
            ->sharpen(10)
            ->crop("crop-center", 1200, 1600)
            ->withResponsiveImages()
            ->performOnCollections("main");
    }

    public function registerMediaCollections(): void
    {
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
}
