<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "content",
        "date",
        "settings"
    ];

    protected $casts = [
        "date" => "date",
        "content" => FlexibleCast::class,
        "settings" => AsArrayObject::class
    ];
}
