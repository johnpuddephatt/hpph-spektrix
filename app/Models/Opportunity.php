<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Opportunity extends Model
{
    use HasFactory;
    use Sluggable;

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
    ];

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
