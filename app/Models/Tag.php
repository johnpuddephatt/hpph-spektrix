<?php
namespace App\Models;

use Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag
{
    public function posts()
    {
        return $this->morphedByMany(Post::class, "taggable");
    }
}
