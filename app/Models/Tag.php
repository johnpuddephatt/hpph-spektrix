<?php
namespace App\Models;

use Spatie\Tags\Tag as SpatieTag;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tag extends SpatieTag
{
    public function posts()
    {
        return $this->morphedByMany(Post::class, "taggable");
    }

    protected static function booted(): void
    {
        static::created(function (Tag $tag) {
            $tag->name = "Oops";
        });
    }
}
