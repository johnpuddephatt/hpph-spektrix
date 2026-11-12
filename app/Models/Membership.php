<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'enabled',
        'show_by_booking_path',
        'name',
        'description',
        'long_description',
        'price',
        'renewal_price',
        'price_period',
        'image',
        'logo',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'enabled' => 'boolean',
        'show_by_booking_path' => 'boolean',
        'benefits' => 'object',
    ];

    protected static function booted()
    {
        static::addGlobalScope('enabled', function (Builder $builder) {
            $builder->where('enabled', true);
        });
    }

    public function scopeShowByBookingPath($query)
    {
        return $query->where('show_by_booking_path', true);
    }

    public function getPriceAttribute($value)
    {
        return $value > 0 ? "£{$value}" : 'Free';
    }

    /**
     * What goes after the price, e.g. "/ year" or "/ 6 months". Null when the
     * editor has left the period blank, or when the membership is free — "Free
     * / year" reads oddly.
     */
    public function getPricePeriodLabelAttribute(): ?string
    {
        $period = trim((string) $this->price_period);

        // Non-breaking spaces so "/ 6 months" never wraps away from the price.
        return $period !== '' && $this->price !== 'Free'
            ? str_replace(' ', "\u{00A0}", "/ {$period}")
            : null;
    }
}
