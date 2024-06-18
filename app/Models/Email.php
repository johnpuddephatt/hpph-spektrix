<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "content",
    ];

    protected $casts = [
        "content" => FlexibleCast::class,
    ];
}
