<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ["title", "content", "slug", "parent_page_id"];

    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title, "-");
        });
    }

    public function getURLAttribute()
    {
        $path = "";
        if ($this->parent_page) {
            $path .= $this->parent_page->URL;
        }
        $path .= "/";
        return $path .= $this->slug;
    }

    public function parent_page()
    {
        return $this->belongsTo(\App\Models\Page::class);
    }

    public function child_pages()
    {
        return $this->hasMany(\App\Models\Page::class, "parent_page_id");
    }
}
