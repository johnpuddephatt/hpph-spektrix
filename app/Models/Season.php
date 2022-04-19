<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ["name", "description"];

    public function instances()
    {
        return $this->hasMany(
            \App\Models\Instance::class,
            "season_name",
            "name"
        );
    }
}
