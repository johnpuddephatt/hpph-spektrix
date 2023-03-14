<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",
        "enabled",
        "show_by_booking_path",
        "name",
        "description",
        "long_description",
        "price",
        "renewal_price",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "enabled" => "boolean",
        "show_by_booking_path" => "boolean",
        "benefits" => "object",
    ];

    protected static function booted()
    {
        static::addGlobalScope("enabled", function (Builder $builder) {
            $builder->where("enabled", true);
        });
    }

    public function scopeShowByBookingPath($query)
    {
        return $query->where("show_by_booking_path", true);
    }

    public function getPriceAttribute($value)
    {
        return $value > 0 ? "£{$value}" : "Free";
    }
}
