<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Astrotomic\CachableAttributes\CachableAttributes;
use Astrotomic\CachableAttributes\CachesAttributes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class Instance extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = "string";

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
        "toddler_friendly",
        "signed_bsl",
        "special_event",

        "analogue",
        "door_time",
        "partnership",

        "external_ticket_link",

        "free",
        "pwyc",
    ];

    protected $casts = [
        "start" => "datetime",
        "captioned" => "boolean",
        "relaxed" => "boolean",
        "cancelled" => "boolean",
        "signed_bsl" => "boolean",
        "autism_friendly" => "boolean",
        "toddler_friendly" => "boolean",
        "free" => "boolean",
        "pwyc" => "boolean",
    ];

    protected $appends = ["start_date", "start_time", "url", "short_id", "format", "availability", "access_tags", "audio_description"];

    public function getAccessTagsAttribute()
    {
        return AccessTag::all()->filter(fn($tag) => $tag->column ? ($this->{$tag->column} ?? false) : false)->values();
    }

    public function event()
    {
        return $this->belongsTo(Event::class, "event_id", "id");
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class)
            ->withPivot("position")
            ->orderByPivot("position");
    }

    public function strands()
    {
        return $this->belongsToMany(Strand::class)
            ->withPivot("position")
            ->orderByPivot("position");
    }

    public function getSeasonAttribute()
    {
        return $this->seasons->first();
    }

    public function getStrandAttribute()
    {
        return $this->strands->first();
    }

    public function getUrlAttribute()
    {
        return $this->event->url;
    }

    public function getAudioDescriptionAttribute()
    {
        return $this->event->audio_description;
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

        return Cache::remember(
            "instance_availability_" . $this->id,
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
                    Log::error("Error fetching availability for instance {$this->id}: " . $e->getMessage());
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


    public function scopeToddlerFriendly($query)
    {
        return $query->where("toddler_friendly", true);
    }


    public function scopeAudioDescribed($query)
    {
        return $query->whereRelation("event", "audio_description", true);
    }

    public static function getInstancesForSlider($type, $name, $exclude = [])
    {
        return Instance::withoutGlobalScope('not_coming_soon')
            ->whereHas('event', function (Builder $query) {
                return $query->shownInProgramme();
            })
            ->whereHas($type . 's', function (Builder $query) use ($name) {
                $query->where('name', $name);
            })
            ->with('event')
            ->whereNotIn('id', $exclude)
            ->get()
            ->sortBy([
                fn($a) => $a->event->coming_soon ? 1 : 0,
                ['start', 'asc'],
            ]);
    }

    public static function getInstancesForProgramme($past = false, $strand = null, $accessibility = null, $date = null, $overwriteCache = false)
    {
        $cacheKey = "instances_for_programme_" . $past . "_" . $strand . "_" . $accessibility . "_" . $date;


        $queryBuilder = function () use ($past, $strand, $accessibility, $date) {
            $instances = \App\Models\Instance::whereHas("event", function ($event) {
                return $event->shownInProgramme();
            })
                ->with(
                    "event:id,slug,name,subtitle,description,certificate_age_guidance,duration,audio_description",
                    "event.featuredImage",
                    "strands:id,slug,name,color,show_on_instance_card",
                )
                ->select(
                    "id",
                    "event_id",
                    "start",
                    "analogue",
                    "special_event",
                    "external_ticket_link",
                    "free",
                    "pwyc",
                    "captioned",
                    "relaxed",
                    "autism_friendly",
                    "toddler_friendly",
                    "signed_bsl",
                );

            if ($past == true) {
                $instances->withoutGlobalScope("future");
            }

            if ($strand) {
                $instances->whereHas("strands", function (Builder $query) use ($strand) {
                    $query->where("strands.slug", $strand);
                });
            }

            if ($accessibility) {
                if ($accessibility == 'audio_description') {
                    $instances->audioDescribed();
                } else {
                    // Slugs come from the URL / access tags, so only allow ones
                    // that actually map to a column on instances.
                    $column = str_replace("-", "_", $accessibility);

                    if (in_array($column, Schema::getColumnListing("instances"), true)) {
                        $instances->where($column, true);
                    }
                }
            }

            if ($date) {
                $instances->whereDate("start", $date);
            }

            return $instances->get();
        };

        if ($overwriteCache) {
            $result = $queryBuilder();
            Cache::put($cacheKey, $result, 300);
            return $result;
        }
        return Cache::remember($cacheKey, 300, $queryBuilder);
    }
}
