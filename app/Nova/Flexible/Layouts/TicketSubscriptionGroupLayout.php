<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\TicketSubscription;

use Laravel\Nova\Fields\Heading;
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
            Heading::make(
                'Leave the list below empty and this shows the passes that belong here: on a '.
                    'strand or season, whichever pass is set to appear on it (its <em>Shown '.
                    'on</em> field); anywhere else, every pass currently on sale. Add passes '.
                    'below to choose them by hand instead.'
            )->asHtml(),
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
     * The subscriptions that are actually buyable, in editor order.
     *
     * An empty list is not "show nothing" but "show the passes that belong
     * here". On a strand or season that means the pass assigned to it, and
     * none if it has not been given one. Anywhere else there is nothing to
     * narrow by, so it means every pass on sale — which is what makes the
     * ticket subscriptions page list them all without an editor doing anything.
     *
     * Gives the view a plain collection of models to loop, so it needs no
     * knowledge of the nested layout fields or of the sale window.
     */
    public function getSubscriptionsAttribute()
    {
        $chosen = collect($this->ticket_subscriptions)
            ->map(fn ($field) => $field?->subscription)
            ->filter()
            ->values();

        if ($chosen->isNotEmpty()) {
            return $chosen;
        }

        $subject = $this->model;

        if ($subject && method_exists($subject, 'ticketSubscription')) {
            return collect([$subject->ticketSubscription])->filter()->values();
        }

        return TicketSubscription::onSale()->orderBy('name')->get();
    }
}
