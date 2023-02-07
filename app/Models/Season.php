<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Season extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "description",
        "short_description",
        "enabled",
        "published",
    ];

    protected $casts = [
        "enabled" => "boolean",
        "published" => "boolean",
    ];

    protected static function booted()
    {
        static::addGlobalScope("published", function (Builder $builder) {
            $builder->where("published", true);
        });

        static::addGlobalScope("enabled", function (Builder $builder) {
            $builder->where("enabled", true);
        });

        static::addGlobalScope("orderByLatest", function (Builder $builder) {
            $builder->orderBy("id", "DESC");
        });
    }

    public function instances()
    {
        return $this->hasMany(Instance::class, "season_name", "name");
    }

    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "name",
            ],
        ];
    }

    public function latest_post()
    {
        return $this->posts()
            ->latest()
            ->limit(1);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
