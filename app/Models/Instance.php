<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class Instance extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * Lifetime for the programme and availability caches.
     *
     * Must be comfortably longer than the five-minute cache:programme /
     * cache:availability schedule. At the old 299/300s these expired at almost
     * exactly the moment the job that refreshes them was due, so a real visitor
     * could land on the gap and pay for the rebuild — the "occasional very slow
     * What's On" symptom.
     */
    public const CACHE_TTL = 600;

    protected static function booted()
    {
        static::addGlobalScope('enabled', function (Builder $builder) {
            $builder->where('enabled', true);
        });

        static::addGlobalScope('not_cancelled', function (Builder $builder) {
            $builder->where('cancelled', false);
        });

        // static::addGlobalScope("on_sale", function (Builder $builder) {
        //     $builder->where("is_on_sale", true);
        // });

        static::addGlobalScope('not_coming_soon', function (Builder $builder) {
            $builder->whereHas('event', function (Builder $query) {
                $query->whereNull('coming_soon');
            });
        });

        static::addGlobalScope('has_event', function (Builder $builder) {
            $builder->whereHas('event');
        });

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('start', 'asc');
        });

        static::addGlobalScope('future', function (Builder $builder) {
            $builder->where('start', '>', Carbon::now()->subMinutes(60));
        });
    }

    protected $fillable = [
        'id',
        'is_on_sale',
        'enabled',

        'event_id',
        'venue',
        'start',
        'start_selling_at_web',
        'stop_selling_at_web',
        'cancelled',
        'captioned',
        'relaxed',
        'autism_friendly',
        'toddler_friendly',
        'signed_bsl',
        'special_event',

        'analogue',
        'door_time',
        'partnership',

        'external_ticket_link',

        'free',
        'pwyc',
    ];

    protected $casts = [
        'start' => 'datetime',
        // Every boolean the import writes needs a cast: without one, true never
        // compares equal to the stored 1, so every instance is dirty on every
        // hourly run — ~365 needless writes.
        'enabled' => 'boolean',
        'is_on_sale' => 'boolean',
        'audio_described' => 'boolean',
        'captioned' => 'boolean',
        'relaxed' => 'boolean',
        'cancelled' => 'boolean',
        'signed_bsl' => 'boolean',
        'autism_friendly' => 'boolean',
        'toddler_friendly' => 'boolean',
        'free' => 'boolean',
        'pwyc' => 'boolean',
    ];

    protected $appends = ['start_date', 'start_time', 'url', 'short_id', 'format', 'availability', 'access_tags', 'audio_description'];

    /**
     * Access tags are the same for every instance, but this accessor is in
     * $appends, so a naive AccessTag::all() here runs once per instance — 336
     * identical queries on a full programme listing. Read the shared, cached
     * collection instead, memoised for the request so a listing costs one lookup
     * rather than one per row.
     */
    protected static ?\Illuminate\Support\Collection $accessTags = null;

    public function getAccessTagsAttribute()
    {
        return static::allAccessTags()
            ->filter(fn ($tag) => $tag->column ? ($this->{$tag->column} ?? false) : false)
            ->values();
    }

    protected static function allAccessTags(): \Illuminate\Support\Collection
    {
        return static::$accessTags ??= Cache::rememberForever(
            'access_tags',
            fn () => AccessTag::all()
        );
    }

    /**
     * Drop the per-request memo. Called by AccessTagsObserver so a long-running
     * queue worker cannot keep serving tags that have since been edited.
     */
    public static function forgetAccessTags(): void
    {
        static::$accessTags = null;
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class)
            ->withPivot('position')
            ->orderByPivot('position');
    }

    public function strands()
    {
        return $this->belongsToMany(Strand::class)
            ->withPivot('position')
            ->orderByPivot('position');
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
        return 'https://system.spektrix.com/'.nova_get_setting('spektrix_client_name').'/api/v3/instances/'.$this->id;
    }

    public function getShortIdAttribute()
    {
        return filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
    }

    public function getStartDateAttribute()
    {
        if ($this->start->isToday()) {
            return 'Today';
        }
        if ($this->start->isTomorrow()) {
            return 'Tomorrow';
        } else {
            return $this->start->format('D d M');
        }
    }

    public function getStartTimeAttribute()
    {
        return $this->start->format('H:i');
    }

    public function getFormatAttribute()
    {
        if ($this->analogue && $this->analogue !== 'Digital') {
            return $this->analogue;
        }
    }

    /**
     * Shown when availability isn't cached. The badge divides seats by capacity,
     * so a missing capacity yields NaN and Alpine simply hides it.
     */
    public const AVAILABILITY_UNKNOWN = [
        'seats' => -1,
        'accessible_seats' => -1,
    ];

    /**
     * Read-only: this NEVER calls Spektrix.
     *
     * availability is in $appends, so fetching here meant one synchronous HTTP
     * call per instance during a page render — ~365 of them on a cold What's On,
     * which exceeded PHP's execution limit and returned a 500. Populating the
     * cache is cache:availability's job; a render only reads what is there.
     */
    public function getAvailabilityAttribute(): array
    {
        return static::availabilityStore()->get(
            $this->availabilityCacheKey(),
            self::AVAILABILITY_UNKNOWN
        );
    }

    /**
     * Fetch live availability from Spektrix and cache it. Called by
     * CacheInstanceAvailability, never during a request.
     */
    public function refreshAvailability(): array
    {
        try {
            $response = Http::timeout(3)->withUrlParameters([
                'spektrix_client_name' => nova_get_setting('spektrix_client_name'),
                'instance_id' => $this->id,
            ])->get(
                'https://system.spektrix.com/{spektrix_client_name}/api/v3/instances/{instance_id}/status?includeLockInformation=true&includeChildPlans=true'
            );
            $json = $response->json();
            $collection = collect($json['lockInfoAvailable']);

            $availability = [
                'capacity' => $json['capacity'],
                'seats' => $json['available'] - $collection->pluck('quantity')->sum(),
                'accessible_seats' => $collection->firstWhere('lockType.name', 'HPPH Wheelchair space')['quantity'] ?? 0,
            ];
        } catch (\Exception $e) {
            Log::error("Error fetching availability for instance {$this->id}: ".$e->getMessage());

            return self::AVAILABILITY_UNKNOWN;
        }

        static::availabilityStore()->put(
            $this->availabilityCacheKey(),
            $availability,
            self::CACHE_TTL
        );

        return $availability;
    }

    public function availabilityCacheKey(): string
    {
        return 'instance_availability_'.$this->id;
    }

    /**
     * A store of its own, so clearing content cannot wipe data that costs one
     * Spektrix call per instance to rebuild. See config/cache.php.
     */
    public static function availabilityStore()
    {
        return Cache::store('availability');
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
        return $query->where('captioned', true);
    }

    public function scopeSignedBsl($query)
    {
        return $query->where('signed_bsl', true);
    }

    public function scopeRelaxed($query)
    {
        return $query->where('relaxed', true);
    }

    public function scopeAutismFriendly($query)
    {
        return $query->where('autism_friendly', true);
    }

    public function scopeToddlerFriendly($query)
    {
        return $query->where('toddler_friendly', true);
    }

    public function scopeAudioDescribed($query)
    {
        return $query->whereRelation('event', 'audio_description', true);
    }

    public static function getInstancesForSlider($type, $name, $exclude = [])
    {
        return Instance::withoutGlobalScope('not_coming_soon')
            ->whereHas('event', function (Builder $query) {
                return $query->shownInProgramme();
            })
            ->whereHas($type.'s', function (Builder $query) use ($name) {
                $query->where('name', $name);
            })
            ->with('event')
            ->whereNotIn('id', $exclude)
            ->get()
            ->sortBy([
                fn ($a) => $a->event->coming_soon ? 1 : 0,
                ['start', 'asc'],
            ]);
    }

    public static function getInstancesForProgramme($past = false, $strand = null, $accessibility = null, $date = null, $overwriteCache = false)
    {
        $cacheKey = 'instances_for_programme_'.$past.'_'.$strand.'_'.$accessibility.'_'.$date;

        $queryBuilder = function () use ($past, $strand, $accessibility, $date) {
            $instances = \App\Models\Instance::whereHas('event', function ($event) {
                return $event->shownInProgramme();
            })
                ->with(
                    'event:id,slug,name,subtitle,description,certificate_age_guidance,duration,audio_description',
                    'event.featuredImage',
                    'strands:id,slug,name,color,show_on_instance_card',
                )
                ->select(
                    'id',
                    'event_id',
                    'start',
                    'analogue',
                    'special_event',
                    'external_ticket_link',
                    'free',
                    'pwyc',
                    'captioned',
                    'relaxed',
                    'autism_friendly',
                    'toddler_friendly',
                    'signed_bsl',
                );

            if ($past == true) {
                $instances->withoutGlobalScope('future');
            }

            if ($strand) {
                $instances->whereHas('strands', function (Builder $query) use ($strand) {
                    $query->where('strands.slug', $strand);
                });
            }

            if ($accessibility) {
                if ($accessibility == 'audio_description') {
                    $instances->audioDescribed();
                } else {
                    // Slugs come from the URL / access tags, so only allow ones
                    // that actually map to a column on instances.
                    $column = str_replace('-', '_', $accessibility);

                    if (in_array($column, Schema::getColumnListing('instances'), true)) {
                        $instances->where($column, true);
                    }
                }
            }

            if ($date) {
                $instances->whereDate('start', $date);
            }

            return $instances->get();
        };

        if ($overwriteCache) {
            $result = $queryBuilder();
            Cache::put($cacheKey, $result, self::CACHE_TTL);

            return $result;
        }

        return Cache::remember($cacheKey, self::CACHE_TTL, $queryBuilder);
    }
}
