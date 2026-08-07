<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpektrixTag extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id', 'enabled', 'name', 'spektrix_tag_group_id'];

    protected $casts = ['enabled' => 'boolean'];

    protected static function booted()
    {
        static::addGlobalScope('enabled', function (Builder $builder) {
            $builder->where('enabled', true);
        });
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(SpektrixTagGroup::class, 'spektrix_tag_group_id');
    }
}
