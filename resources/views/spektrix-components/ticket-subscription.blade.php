{{--
    A ticket subscription (flex pass), laid out two-up: what it is on the left,
    what you get and how to buy it on the right.

    Expects $subscription. $pretitle is the small line above the name, and $dark
    themes the panel for a black background.

    Shared by the strand and season pages, which show the pass attached to them,
    and by the two flexible content blocks — so a pass reads the same wherever an
    editor puts it.

    Everything beyond the name and the prices is editor-supplied: the Spektrix API
    carries no terms and no benefits — not even the number of tickets in a pass,
    which lives only in the name of its pricing set.
--}}

<div class="md:grid md:grid-cols-2 md:gap-12 lg:gap-16">

    <div class="dark:text-white">
        <p class="type-xs-mono mb-3" @if ($dark ?? false) style="color: @yield('color')" @endif>
            {{ $pretitle ?? 'Buy a pass and save' }}
        </p>

        <h3 class="type-regular lg:type-medium mb-4">{{ $subscription->name }}</h3>

        @if ($subscription->description)
            <p class="type-regular max-w-xl !font-normal">{{ $subscription->description }}</p>
        @endif
    </div>

    <div class="mt-8 dark:text-white md:mt-0">
        {{-- The benefits and the buy rows read as one list, so the rule that
             opens it belongs to the pair rather than to either one — otherwise a
             pass with benefits doubles its border where they meet, and a pass
             without them loses it. --}}
        <div class="border-t border-sand-dark dark:border-gray-dark">
            @if ($subscription->benefits)
                <ul>
                    @foreach ($subscription->benefits as $benefit)
                        {{-- Same tick bullet as the key features on the jobs page. --}}
                        <li
                            class="type-xs-mono flex items-center gap-2 border-b border-sand-dark py-3 dark:border-gray-dark">
                            @svg('tick', 'h-6 w-6 shrink-0 rounded-full bg-yellow p-1 text-black')
                            <span>{{ $benefit }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif

            @include('spektrix-components.ticket-subscription-buy', [
                'subscription' => $subscription,
                'dark' => $dark ?? false,
            ])
        </div>

        @if ($subscription->terms)
            {{-- gray-medium is too dim against black; gray-light reads there. --}}
            <p class="type-xs-mono mt-4 text-gray-medium dark:text-gray-light">{{ $subscription->terms }}</p>
        @endif
    </div>
</div>
