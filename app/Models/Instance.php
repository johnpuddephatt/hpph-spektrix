<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Instance extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = "string";

    protected static function booted()
    {
        static::addGlobalScope("order", function (Builder $builder) {
            $builder
                ->orderBy("start", "asc")
                ->where("start", ">", Carbon::today());
        });
    }

    protected $fillable = [
        "id",
        "is_on_sale",
        "event_id",
        "start",
        "start_selling_at_web",
        "stop_selling_at_web",
        "cancelled",
        "audio_described",
        "captioned",
        "signed_bsl",
        "special_event",
        "accessibility",
        "analogue",
        "door_time",
        "short_playing_with_feature",
        "special_event_into_qa_panel",
        "partnership",

        "season_name",
        "strand_name",
    ];

    protected $casts = [
        "start" => "datetime",
        "captioned" => "boolean",
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, "event_id", "id");
    }

    public function season()
    {
        return $this->belongsTo(Season::class, "season_name", "name");
    }

    public function strand()
    {
        return $this->belongsTo(Strand::class, "strand_name", "name");
    }

    public function scopeToday($query)
    {
        return $query->whereDate("start", Carbon::today());
    }

    public function scopeTomorrow($query)
    {
        return $query->whereDate("start", Carbon::today()->addDay());
    }

    public function scopeCaptioned($query)
    {
        return $query->where("captioned", true);
    }

    public function scopeAudioDescribed($query)
    {
        return $query->where("audio_described", true);
    }

    public function scopeSignedBsl($query)
    {
        return $query->where("signed_bsl", true);
    }
}
