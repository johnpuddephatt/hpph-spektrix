{{--
    The buy options for a ticket subscription: one row per Spektrix pricing set,
    each with its own add-to-basket button. Expects $subscription and $dark.

    Spektrix ships no web component for ticket subscriptions — unlike memberships,
    donations and merchandise — so this posts to the v3 API itself, via
    resources/js/ticket-subscription.js. The success and failure affordances
    deliberately mirror the web components' so it behaves like the rest of the site.
--}}

@foreach ($subscription->pricing_set_rows as $row)
    <div class="border-b border-sand-dark py-3 dark:border-gray-dark" x-data="ticketSubscription({ endpoint: @js($subscription->basket_endpoint), pricingSetId: @js($row['id']) })">

        <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-3">
            <span class="type-regular">{{ $row['label'] }}</span>

            {{-- text-black is explicit: the panel sets dark:text-white on its
                 columns, which the button would otherwise inherit onto a yellow
                 background.

                 In a dark context the fill takes the page's own accent, the way
                 merchandise-group does. bg-yellow stays as the base for pages
                 that define no colour, and hover uses opacity rather than
                 bg-opacity so it still works once an inline background-color is
                 in play.

                 Deliberately not x-cloaked: the call to action should paint with
                 the page rather than waiting on Alpine. --}}
            <button type="button"
                class="type-regular shrink-0 rounded bg-yellow py-2 pl-4 pr-3 text-black transition hover:opacity-90 disabled:opacity-60"
                @if ($dark ?? false) style="background-color: @yield('color')" @endif x-on:click="add()"
                x-bind:disabled="busy" x-show="!added">
                <span x-show="!busy">Add to basket</span>
                <span x-show="busy" x-cloak>Adding&hellip;</span>
                @svg('arrow-right', 'inline-block h-4 w-4 ml-1')
            </button>

            <div class="type-xs-mono shrink-0" x-show="added" x-cloak>
                Added to basket.
                {{-- Null when no page uses the basket template, which would
                     otherwise render as href="" — a link that silently reloads
                     the page. --}}
                @if (\App\Models\Page::getTemplateUrl('basket-page'))
                    <a class="underline" href="{{ \App\Models\Page::getTemplateUrl('basket-page') }}">Go to basket</a>
                @endif
            </div>
        </div>

        <p class="type-xs-mono mt-2" x-show="failed" x-cloak>
            This couldn&rsquo;t be added to your basket.
        </p>
    </div>
@endforeach
