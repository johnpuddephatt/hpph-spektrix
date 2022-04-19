<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "spektrix_id",
        "is_on_sale",
        "event_id",
        "start",
        "start_selling_at_web",
        "stop_selling_at_web",
        "cancelled",
        "analogue",
        "captioned",
        "special_event",
        "short_film_with_feature",
        "audio_described",
        "season_name",
        "target_audience",
        "target_audience_2",
        "signed_bsl",
        "relaxed_performance",
    ];

    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class());
    }

    public function season()
    {
        return $this->belongsTo(
            \App\Models\Season::class,
            "season_name",
            "name"
        );
    }
}
