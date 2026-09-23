<div id="{{ $layout->menuAnchor() }}" class="relative scroll-mt-24 overflow-x-hidden bg-black-light px-4 py-20 lg:py-36">

    <div class="grid items-center gap-8 overflow-hidden rounded bg-black py-4 px-4 lg:px-8 lg:grid-cols-7">
        <img class="aspect-square object-contain lg:col-span-2" src="{{ Storage::url($layout->membership->image) }}" />

        <div class="px-8 py-8 lg:col-span-3">
            <h2 class="type-medium lg:type-large relative mb-2 text-white">
                {{ $layout->title }}
            </h2>
            <p class="type-small relative mb-12 text-white">
                {{ $layout->subtitle }}
            </p>

            <ul class="max-w-lg divide-y divide-black-light text-white">
                @foreach ($layout->membership->benefits as $benefit)
                    <li class="type-xs-mono flex items-center gap-2 py-3 lg:py-4">
                        @svg('tick', 'h-6 w-6 p-1 mr-2 rounded-full bg-yellow text-black inline-block')
                        {{ $benefit }}
                    </li>
                @endforeach
            </ul>

            <spektrix-memberships class="relative mt-12 block max-w-lg pb-2"
                client-name="{{ $settings['spektrix_client_name'] }}"
                custom-domain="{{ $settings['spektrix_custom_domain'] }}" membership-id="{{ $layout->membership->id }}">
                <button
                    class="type-regular w-full rounded bg-yellow py-4 text-center text-black transition hover:bg-opacity-90"
                    data-submit-membership>Add to basket</button>
                <div class="relative -mt-14" data-success-container style="display: none;">
                    <div
                        class="type-regular max-w-lg rounded bg-yellow-dark px-6 py-4 text-center leading-tight text-black">
                        Added to basket</div>
                    <p class="type-small mt-4 text-white">Want your free membership to continue until your 26th
                        birthday? After
                        you’ve processed your order, visit your account page and provide us with your date of birth.</p>
                </div>
                <div class="absolute left-0 right-0 top-full bg-yellow-dark px-6 py-2 text-center font-bold leading-tight text-black"
                    data-fail-container style="display: none;">Something went wrong.</div>
            </spektrix-memberships>
        </div>

        @if ($layout->films_of_the_week->isNotEmpty())
            <div class="mx-auto mb-12 max-w-lg w-full text-white lg:col-span-2 lg:mb-0">

                <div class="rounded bg-black-light pt-4">
                    <h3 class="type-xs-mono mb-2 px-4 text-white">Upcoming 15–25 Film of the Week</h3>
                    <ul class="divide-y divide-gray-dark border-t border-gray-dark">
                        @foreach ($layout->films_of_the_week as $film)
                            <li class="group relative flex gap-4 p-4">
                                <div class="relative aspect-video w-32 shrink-0 overflow-hidden rounded bg-black">
                                    @if ($film->event->featuredImage)
                                        {!! $film->event->featuredImage->img('wide')->attributes(['loading' => 'lazy', 'class' => 'absolute inset-0 transition duration-500 group-hover:scale-105']) !!}
                                    @endif
                                </div>
                                <div class="flex min-w-0 flex-col">
                                    <div class="type-xs-mono flex gap-1">
                                        <span class="text-yellow">{{ $film->label }}</span>
                                        <span class="text-gray-medium">|</span>
                                        <span>{{ $film->dates }}</span>
                                    </div>
                                    <h4 class="type-small mb-3 mt-1">{{ $film->event->name }}</h4>
                                    <div class="mt-auto space-x-1">
                                        <a class="type-xs inline-block rounded bg-sand-light px-3 py-0.5 !font-bold text-black transition before:absolute before:inset-0 hover:bg-gray-dark hover:text-sand-light"
                                            href="{{ $film->event->url }}">Info</a>
                                        <button
                                            class="type-xs relative z-[1] inline-block rounded border border-yellow bg-yellow px-3 py-0.5 !font-bold text-black transition hover:bg-black hover:text-yellow"
                                            @click="$dispatch('booking', { eventID: '{{ $film->event->id }}', event: '{{ htmlentities($film->event->name, ENT_QUOTES) }}', certificate: '{{ htmlentities($film->event->certificate_age_guidance, ENT_QUOTES) }}' })">Book</button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>

<x-marquee class="!bg-sand" />
