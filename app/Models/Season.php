<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Season extends Model
{
    use HasFactory;
    use Sluggable;
    public $timestamps = false;

    protected $fillable = ["name", "description", "short_description"];

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
}
