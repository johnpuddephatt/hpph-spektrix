{{--
    The "details" style of the single membership block: what the membership is on
    the left, what you get and how to buy it on the right.

    Deliberately the same shape as the ticket subscription panel
    (spektrix-components/ticket-subscription) so the two read as a family when
    they sit on the same page.

    Expects $layout, $membership and $dark. The name and price come from Spektrix;
    the description, benefits and image are added by an editor under Memberships.
--}}

<div id="{{ Str::slug($layout->title ?: $membership->name) }}" @class(['container my-12 lg:my-16', 'dark' => $dark])>
    <div class="md:grid md:grid-cols-2 md:gap-12 lg:gap-16">

        <div class="dark:text-white">
            <p class="type-xs-mono mb-3" @if ($dark) style="color: @yield('color')" @endif>
                {{ $layout->subtitle ?: 'Become a member' }}
            </p>

            <h2 class="type-regular lg:type-medium mb-4">{{ $layout->title ?: $membership->name }}</h2>

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
                                @svg('tick', 'h-6 w-6 shrink-0 rounded-full bg-yellow p-1 text-black')
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
                            {{ $membership->price }}@if ($membership->price !== 'Free')<span class="!font-normal">&nbsp;/&nbsp;year</span>@endif
                        </span>

                        {{-- text-black is explicit: the column sets dark:text-white,
                             which the button would otherwise inherit onto yellow. --}}
                        <button type="button" data-submit-membership
                            class="type-regular shrink-0 rounded bg-yellow py-2 pl-4 pr-3 text-black transition hover:opacity-90"
                            @if ($dark) style="background-color: @yield('color')" @endif>
                            Add to basket
                            @svg('arrow-right', 'inline-block h-4 w-4 ml-1')
                        </button>

                        <div class="type-xs-mono shrink-0" data-success-container style="display: none;">
                            Added to basket.
                            @if (\App\Models\Page::getTemplateUrl('basket-page'))
                                <a class="underline" href="{{ \App\Models\Page::getTemplateUrl('basket-page') }}">Go to basket</a>
                            @endif
                        </div>
                    </div>

                    <p class="type-xs-mono mt-2" data-fail-container style="display: none;">
                        This couldn&rsquo;t be added to your basket.
                    </p>
                </spektrix-memberships>
            </div>

            @if (\App\Models\Page::getTemplateUrl('gift-membership-page'))
                <a href="{{ \App\Models\Page::getTemplateUrl('gift-membership-page') . '?selected=' . $membership->id }}"
                    class="type-xs-mono mt-4 inline-block underline">Gift this membership</a>
            @endif
        </div>
    </div>
</div>
