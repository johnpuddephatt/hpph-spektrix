<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class TicketSubscriptionGroupLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'ticket-subscription-group';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Ticket subscriptions';

    public $collapsedPreviewAttribute = 'title';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Title')->help('Optional heading shown above the subscriptions.'),
            Textarea::make('Introduction')->rows(3),
            Flexible::make('Ticket subscriptions', 'ticket_subscriptions')
                ->addLayout(\App\Nova\Flexible\Layouts\TicketSubscriptionLayout::class)
                ->fullWidth()
                ->button('Add ticket subscription'),
        ];
    }

    public function getTicketSubscriptionsAttribute()
    {
        return $this->flexible('ticket_subscriptions', [
            'ticket-subscription' => \App\Nova\Flexible\Layouts\TicketSubscriptionLayout::class,
        ]);
    }

    /**
     * The chosen subscriptions that are actually buyable, in editor order.
     *
     * Gives the view a plain collection of models to loop, so it needs no
     * knowledge of the nested layout fields or of the sale window.
     */
    public function getSubscriptionsAttribute()
    {
        return collect($this->ticket_subscriptions)
            ->map(fn ($field) => $field?->subscription)
            ->filter()
            ->values();
    }
}
