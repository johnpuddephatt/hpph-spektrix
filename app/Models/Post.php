<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ["title", "content", "slug"];

    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title, "-");
        });
    }
}
