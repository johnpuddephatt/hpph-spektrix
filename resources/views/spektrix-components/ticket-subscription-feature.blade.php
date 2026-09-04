{{--
    The flex pass sold alongside a strand or season, shown between the page's own
    description and its what's on slider. Expects $subscription, which is the
    page's `ticketSubscription` relation and so may be null.

    That relation is already scoped to a pass that can be bought, so there is
    nothing to check here beyond whether one exists at all.

    Black with the page's accent, matching the what's on section below it rather
    than the coloured description band above.
--}}

@if ($subscription)
    <div class="dark bg-black">
        <div class="container py-16 lg:py-24">
            @include('spektrix-components.ticket-subscription', [
                'subscription' => $subscription,
                'dark' => true,
            ])
        </div>
    </div>
@endif
