<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessTag extends Model
{
    // The table associated with the model.
    protected $table = 'access_tags';

    // The attributes that are mass assignable.
    protected $fillable = [
        'label',
        'abbreviation',
        'read_more_link',
        'description',
        'booking_warning',
        'slug',
    ];

    // If you want timestamps, uncomment the following line:
    public $timestamps = false;

    /**
     * The instances column this tag maps to. Slugs are entered by hand in Nova,
     * so tolerate hyphens where the column uses underscores.
     */
    public function getColumnAttribute(): ?string
    {
        return $this->slug ? str_replace('-', '_', $this->slug) : null;
    }
}
