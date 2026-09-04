<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * A Spektrix ticket subscription — a flex pass, sold as a prepaid bundle of
 * ticket vouchers.
 *
 * Redemption is entirely Spektrix's business: eligible vouchers are applied
 * automatically for a logged-in customer and cannot be overridden online, so
 * nothing here touches the booking path. This model exists only to sell them.
 *
 * The id is a slug of the structure name rather than a Spektrix id — see the
 * migration for why.
 */
class TicketSubscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'enabled',
        'name',
        'spektrix_description',
        'pricing_sets',
        'on_sale_at',
        'off_sale_at',
        'description',
        'benefits',
        'terms',
    ];

    // Without the boolean cast the import's `true` never matches the stored 1, so
    // every row counts as dirty on every run — needless writes, and a full cache
    // clear through the observer. Same reasoning as Fund and Membership.
    protected $casts = [
        'enabled' => 'boolean',
        'pricing_sets' => 'array',
        'benefits' => 'object',
        'on_sale_at' => 'datetime',
        'off_sale_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::addGlobalScope('enabled', function (Builder $builder) {
            $builder->where('enabled', true);
        });
    }

    /**
     * The strand or season this pass is sold alongside. Set by an editor, so it
     * is deliberately outside the set of columns the import writes.
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Within the web-channel sale window. Either bound may be absent, which
     * Spektrix means as "no bound", not "never".
     */
    public function isOnSale(): bool
    {
        $now = Carbon::now();

        if ($this->on_sale_at && $this->on_sale_at->isAfter($now)) {
            return false;
        }

        if ($this->off_sale_at && $this->off_sale_at->isBefore($now)) {
            return false;
        }

        return true;
    }

    public function scopeOnSale($query)
    {
        $now = Carbon::now();

        return $query
            ->where(fn ($q) => $q->whereNull('on_sale_at')->orWhere('on_sale_at', '<=', $now))
            ->where(fn ($q) => $q->whereNull('off_sale_at')->orWhere('off_sale_at', '>=', $now));
    }

    /**
     * "£60", "£62.50", "Free" — trailing zeroes trimmed, as Membership does.
     */
    protected function formatPrice(float $price): string
    {
        return $price > 0 ? '£'.rtrim(rtrim(number_format($price, 2), '0'), '.') : 'Free';
    }

    /**
     * "Standard £60.00, Concession £45.00" — the readable form of the pricing
     * sets, for Nova and anywhere else that wants them in one line.
     */
    public function getPricingSetSummaryAttribute(): string
    {
        return collect($this->pricing_sets ?? [])
            ->map(fn ($set) => trim(($set['name'] ?? '').' £'.number_format($set['price'] ?? 0, 2)))
            ->implode(', ');
    }

    /**
     * One buy option per pricing set: the `id` to post, and the label to put
     * beside the button — "Buy 5 for £30", from the name the client gives the
     * set in Spektrix.
     *
     * A list rather than an id-keyed map: nothing guarantees the ids are
     * distinct, and keying would silently drop a duplicate.
     */
    public function getPricingSetRowsAttribute(): array
    {
        return array_map(function ($set) {
            $price = $this->formatPrice($set['price'] ?? 0);
            $name = trim($set['name'] ?? '');

            return [
                'id' => $set['id'],
                // A single set is often named after the subscription itself, which
                // beside the heading would just read twice. Then the price alone
                // says everything the row needs to.
                'label' => $name === '' || $name === $this->name ? $price : $name.' for '.$price,
            ];
        }, $this->pricing_sets ?? []);
    }

    /**
     * Where the browser posts to add this to the basket.
     *
     * Deliberately built on the custom domain rather than system.spektrix.com:
     * the basket lives in a cookie session shared with the Spektrix iframes, and
     * only the custom domain keeps that cookie first-party to the site.
     */
    public function getBasketEndpointAttribute(): string
    {
        return 'https://'
            .nova_get_setting('spektrix_custom_domain')
            .'/'
            .nova_get_setting('spektrix_client_name')
            .'/api/v3/basket/ticket-subscriptions';
    }
}
