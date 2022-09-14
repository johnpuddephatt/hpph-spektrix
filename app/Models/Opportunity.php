<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Opportunity extends Model
{
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
    ];

    protected $casts = [
        "published" => "boolean",
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
}
