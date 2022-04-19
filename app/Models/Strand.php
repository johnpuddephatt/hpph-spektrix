<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strand extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ["name", "description"];

    public function events()
    {
        return $this->hasMany(\App\Models\Event::class, "strand_name", "name");
    }
}
