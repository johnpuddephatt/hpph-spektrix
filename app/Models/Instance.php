<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Illuminate\Support\Facades\Log;

class Instance extends Model implements CachableAttributes
{
    use HasFactory;
    use CachesAttributes;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = "string";

    protected $cachableAttributes = [
        'availability',
    ];

    protected static function booted()
    {
        static::addGlobalScope("enabled", function (Builder $builder) {
            $builder->where("enabled", true);
        });

        static::addGlobalScope("not_cancelled", function (Builder $builder) {
            $builder->where("cancelled", false);
        });

        // static::addGlobalScope("on_sale", function (Builder $builder) {
        //     $builder->where("is_on_sale", true);
        // });

        static::addGlobalScope("not_coming_soon", function (Builder $builder) {
            $builder->whereHas('event', function (Builder $query) {
                $query->whereNull('coming_soon');
            });
        });

        static::addGlobalScope("has_event", function (Builder $builder) {
            $builder->whereHas("event");
        });

        static::addGlobalScope("order", function (Builder $builder) {
            $builder->orderBy("start", "asc");
        });

        static::addGlobalScope("future", function (Builder $builder) {
            $builder->where("start", ">", Carbon::now()->subMinutes(60));
        });
    }

    protected $fillable = [
        "id",
        "is_on_sale",
        "enabled",

        "event_id",
        "venue",
        "start",
        "start_selling_at_web",
        "stop_selling_at_web",
        "cancelled",
        "captioned",
        "relaxed",
        "autism_friendly",
        "signed_bsl",
        "special_event",

        "analogue",
        "door_time",
        "partnership",

        "season_name",
        "strand_name",
        "external_ticket_link",
    ];

    protected $casts = [
        "start" => "datetime",
        "captioned" => "boolean",
        "relaxed" => "boolean",
        "autism_friendly" => "boolean",
    ];

    protected $appends = ["start_date", "start_time", "url", "short_id", "format"];

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
        return $this->event->url;
    }

    public function getSpektrixApiLinkAttribute(): string
    {
        return 'https://system.spektrix.com/' . nova_get_setting('spektrix_client_name') .  '/api/v3/instances/' . $this->id;
    }

    public function getShortIdAttribute()
    {
        return filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
    }

    public function getStartDateAttribute()
    {
        if ($this->start->isToday()) {
            return "Today";
        }
        if ($this->start->isTomorrow()) {
            return "Tomorrow";
        } else {
            return $this->start->format("D d M");
        }
    }

    public function getStartTimeAttribute()
    {
        return $this->start->format("H:i");
    }

    public function getFormatAttribute()
    {

        if ($this->analogue && $this->analogue !== 'Digital') {
            return $this->analogue;
        }
    }

    public function getAvailabilityAttribute()
    {
        return $this->remember(
            "availability",
            299,
            function (): array {
                try {
                    $response = Http::timeout(3)->withUrlParameters([
                        'spektrix_client_name' => nova_get_setting("spektrix_client_name"),
                        'instance_id' => $this->id,
                    ])->get(
                        "https://system.spektrix.com/{spektrix_client_name}/api/v3/instances/{instance_id}/status?includeLockInformation=true&includeChildPlans=true"
                    );
                    $json = $response->json();
                    $collection = collect($json['lockInfoAvailable']);

                    return [
                        'capacity' => $json['capacity'],
                        'seats' => $json['available'] - $collection->pluck('quantity')->sum(),
                        'accessible_seats' => $collection->firstWhere('lockType.name', 'HPPH Wheelchair space')['quantity'] ?? 0
                    ];
                } catch (\Exception $e) {
                    Log::error($e);
                    return [
                        'seats' => -1,
                        'accessible_seats' => -1
                    ];
                }
            }
        );
    }
    // public function scopeToday($query)
    // {
    //     return $query->whereDate("start", Carbon::today());
    // }

    // public function scopeTomorrow($query)
    // {
    //     return $query->whereDate("start", Carbon::today()->addDay());
    // }

    // public function scopeThisWeek($query)
    // {
    //     return $query->whereBetween("start", [
    //         Carbon::today(),
    //         Carbon::now()->endOfWeek(),
    //     ]);
    // }

    public function scopeCaptioned($query)
    {
        return $query->where("captioned", true);
    }

    public function scopeSignedBsl($query)
    {
        return $query->where("signed_bsl", true);
    }

    public function scopeRelaxed($query)
    {
        return $query->where("relaxed", true);
    }

    public function scopeAutismFriendly($query)
    {
        return $query->where("autism_friendly", true);
    }

    public function scopeAudioDescribed($query)
    {
        return $query->whereRelation("event", "audio_description", true);
    }
}
