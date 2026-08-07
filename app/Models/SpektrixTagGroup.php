<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpektrixTagGroup extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id', 'enabled', 'name', 'description'];

    protected $casts = ['enabled' => 'boolean'];

    /**
     * Only groups present in the last sync. Disabled groups are kept so that a
     * signup form's saved selection is not lost if Spektrix temporarily stops
     * publishing them.
     */
    protected static function booted()
    {
        static::addGlobalScope('enabled', function (Builder $builder) {
            $builder->where('enabled', true);
        });
    }

    public function tags(): HasMany
    {
        return $this->hasMany(SpektrixTag::class);
    }
}
