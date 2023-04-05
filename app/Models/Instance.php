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
        static::addGlobalScope("has_event", function (Builder $builder) {
            $builder->whereHas("event");
        });
    }

    protected $fillable = [
        "id",
        "is_on_sale",
        "event_id",
        "venue",
        "start",
        "start_selling_at_web",
        "stop_selling_at_web",
        "cancelled",
        "audio_described",
        "captioned",
        "relaxed",
        "signed_bsl",
        "special_event",

        "analogue",
        "door_time",
        "partnership",

        "season_name",
        "strand_name",
    ];

    protected $casts = [
        "start" => "datetime",
        "captioned" => "boolean",
    ];

    protected $appends = ["start_date", "start_time", "url", "short_id"];

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

    public function getUrlAttribute()
    {
        return $this->event->url . "#" . $this->start->timestamp;
    }

    public function getShortIdAttribute()
    {
        return filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
    }

    public function getStartDateAttribute()
    {
        return $this->start->format("D d M");
    }

    public function getStartTimeAttribute()
    {
        return $this->start->format("H:i");
    }

    public function scopeToday($query)
    {
        return $query->whereDate("start", Carbon::today());
    }

    public function scopeTomorrow($query)
    {
        return $query->whereDate("start", Carbon::today()->addDay());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween("start", [
            Carbon::today(),
            Carbon::now()->endOfWeek(),
        ]);
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
