<?php

namespace App\Nova\Flexible\Layouts;

use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class TicketSubscriptionLayout extends Layout
{
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'ticket-subscription';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Ticket subscription';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Ticket subscription', 'ticket_subscription_id')
                ->options(
                    static::cachedOptions(
                        'ticket_subscriptions',
                        fn () => \App\Models\TicketSubscription::pluck('name', 'id')
                    )
                )
                ->searchable()
                ->help(
                    'Only subscriptions that are currently in Spektrix appear here.
                    Add the image and benefits under Ticket subscriptions.'
                ),
        ];
    }

    /**
     * The chosen subscription, or null if it isn't currently buyable — either it
     * has dropped out of the Spektrix import or it sits outside its web-channel
     * sale window. Resolved here rather than in the view so the Blade templates
     * stay free of logic.
     */
    public function getSubscriptionAttribute()
    {
        $subscription = \App\Models\TicketSubscription::find($this->ticket_subscription_id);

        return $subscription && $subscription->isOnSale() ? $subscription : null;
    }
}
