{{--
    Ticket subscriptions (flex passes) on a page.

    $layout->subscriptions is already filtered to the ones on sale, and is
    either what an editor picked by hand or — when they picked nothing — the
    passes assigned to this strand or season, so the view only has to lay
    them out.

    Passes stack rather than sit in a grid: each one is a two-column panel, and
    the client expects only ever a handful on sale at a time.

    No @push('webComponents') needed: no web component is involved, and the basket
    summary that reflects the new item is already in the site header.
--}}

@if ($layout->subscriptions->isNotEmpty())
    {{-- `dark` switches the panels' dark: variants on. Set by pages that render
         blocks against black, such as strands and seasons. The yellow title bar
         sits inside it so the whole block themes as one. --}}
    <div @class(['dark' => $dark ?? false])>

        @if ($layout->title)
            {{-- Takes the page's accent in a dark context, so the block sits with
                 the rest of a strand or season rather than always reading yellow. --}}
            <div class="mb-8 bg-yellow"
                @if ($dark ?? false) style="background-color: @yield('color')" @endif>
                <h2 class="type-regular container py-8 text-black">
                    {{ $layout->title }}
                </h2>
            </div>
        @endif

        <div class="container space-y-16 py-16 lg:py-24 {{ $dark ? 'bg-black-light' : null }}">

            @if ($layout->introduction)
                <p class="type-regular max-w-2xl !font-normal dark:text-white">{{ $layout->introduction }}</p>
            @endif

            @foreach ($layout->subscriptions as $subscription)
                @include('spektrix-components.ticket-subscription', [
                    'subscription' => $subscription,
                    'dark' => $dark ?? false,
                ])
            @endforeach

        </div>
    </div>
@endif
