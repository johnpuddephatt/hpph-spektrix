{{--
    The "details" style of the single membership block: what the membership is on
    the left, what you get and how to buy it on the right.

    Deliberately the same shape as the ticket subscription panel
    (spektrix-components/ticket-subscription) so the two read as a family when
    they sit on the same page.

    Expects $layout, $membership and $dark. The name and price come from Spektrix;
    the description, benefits and image are added by an editor under Memberships.
--}}

{{-- The id is what a direct link to this section points at; the heading below
     links to it, so an editor can click the heading to get the URL. --}}
<div id="{{ Str::slug($layout->title ?: $membership->name) }}" @class([
    'container scroll-mt-24 py-12 lg:py-16',
    'dark bg-black-light' => $dark,
])>
    <div class="md:grid md:grid-cols-2 md:gap-12 lg:gap-16">

        <div class="dark:text-white">
            <p class="type-xs-mono mb-3" @if ($dark) style="color: @yield('color')" @endif>
                {{ $layout->subtitle ?: 'Become a member' }}
            </p>

            {{-- Same self-link as headings in the text block. --}}
            <h2 class="type-regular lg:type-medium mb-4">
                <a
                    href="#{{ Str::slug($layout->title ?: $membership->name) }}">{{ $layout->title ?: $membership->name }}</a>
            </h2>

            @if ($membership->description)
                <p class="type-regular max-w-xl !font-normal">{{ $membership->description }}</p>
            @endif

            @if ($membership->image)
                <img src="{{ Storage::url($membership->image) }}" alt=""
                    class="mt-8 block aspect-video w-full max-w-xl object-cover object-center" />
            @endif
        </div>

        <div class="mt-8 dark:text-white md:mt-0">
            <div class="border-t border-sand-dark dark:border-gray-dark">
                @if ($membership->benefits)
                    <ul>
                        @foreach ($membership->benefits as $benefit)
                            <li
                                class="type-xs-mono flex items-center gap-2 border-b border-sand-dark py-3 dark:border-gray-dark">
                                {{-- Takes the page's accent in a dark context, like the
                                     add to basket button; @svg can't take a style, hence
                                     the wrapper. --}}
                                <span class="shrink-0 rounded-full bg-yellow p-1 text-black"
                                    @if ($dark) style="background-color: @yield('color')" @endif>
                                    @svg('tick', 'h-4 w-4')
                                </span>
                                <span>{{ $benefit }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                {{-- Memberships do have a Spektrix web component (unlike ticket
                     subscriptions), so the buy row hands off to it rather than
                     posting to the API itself. The affordances match the ticket
                     subscription buy row. --}}
                <spektrix-memberships class="block border-b border-sand-dark py-3 dark:border-gray-dark"
                    client-name="{{ $settings['spektrix_client_name'] }}"
                    custom-domain="{{ $settings['spektrix_custom_domain'] }}" membership-id="{{ $membership->id }}">

                    <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-3">
                        <span class="type-regular">
                            {{ $membership->price }}@if ($membership->price_period_label)
                                <span class="!font-normal">&nbsp;{{ $membership->price_period_label }}</span>
                            @endif
                        </span>

                        <div class="flex flex-wrap items-center gap-2">
                            {{-- Secondary to add to basket: an outline rather than a
                                 fill, as the gift button in the membership comparison
                                 block is. The ring is inset so it is the same height
                                 as the filled button beside it. "Give as a gift"
                                 rather than "gift this membership", since some of
                                 these (the Baby Bundle) aren't sold as memberships. --}}
                            @if (\App\Models\Page::getTemplateUrl('gift-membership-page'))
                                <a href="{{ \App\Models\Page::getTemplateUrl('gift-membership-page') . '?selected=' . $membership->id }}"
                                    class="type-regular rounded px-4 py-2 ring-1 ring-inset ring-black transition hover:bg-black/5 dark:ring-white dark:hover:bg-white/10">
                                    Give as a gift
                                </a>
                            @endif

                            {{-- text-black is explicit: the column sets dark:text-white,
                                 which the button would otherwise inherit onto yellow. --}}
                            <button type="button" data-submit-membership
                                class="type-regular rounded bg-yellow py-2 pl-4 pr-3 text-black transition hover:opacity-90"
                                @if ($dark) style="background-color: @yield('color')" @endif>
                                Add to basket
                                @svg('arrow-right', 'inline-block h-4 w-4 ml-1')
                            </button>
                        </div>

                        <div class="type-xs-mono shrink-0" data-success-container style="display: none;">
                            Added to basket.
                            @if (\App\Models\Page::getTemplateUrl('basket-page'))
                                <a class="underline" href="{{ \App\Models\Page::getTemplateUrl('basket-page') }}">Go to
                                    basket</a>
                            @endif
                        </div>
                    </div>

                    <p class="type-xs-mono mt-2" data-fail-container style="display: none;">
                        This couldn&rsquo;t be added to your basket.
                    </p>
                </spektrix-memberships>
            </div>
        </div>
    </div>
</div>
