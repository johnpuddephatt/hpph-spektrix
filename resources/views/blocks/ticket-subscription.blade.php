{{--
    A single ticket subscription (flex pass), placed on a page on its own.

    TicketSubscriptionGroupLayout renders several of these; the shared panel lives
    in spektrix-components/ticket-subscription.

    $layout->subscription is null when the pass has dropped out of the Spektrix
    import or is outside its sale window, in which case the block renders nothing.

    Redemption needs nothing from us. Spektrix applies a customer's vouchers
    automatically in the normal booking path once they're logged in.

    No @push('webComponents') needed: no web component is involved, and the basket
    summary that reflects the new item is already in the site header.
--}}

@if ($layout->subscription)
    {{-- `dark` switches the panel's dark: variants on. Set by pages that render
         blocks against black, such as strands and seasons. --}}
    <div @class(['container my-12', 'dark' => $dark ?? false])>
        @include('spektrix-components.ticket-subscription', [
            'subscription' => $layout->subscription,
            'dark' => $dark ?? false,
        ])
    </div>
@endif
