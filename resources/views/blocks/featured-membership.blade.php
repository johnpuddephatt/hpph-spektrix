<div id="{{ $layout->menuAnchor() }}" class="relative scroll-mt-24 overflow-x-hidden bg-black-light px-4 py-20 lg:py-36">

    <div class="grid items-center overflow-hidden rounded gap-8 p-4 bg-black lg:grid-cols-7">
        <img class="aspect-square lg:col-span-2 object-contain" src="{{ Storage::url($layout->membership->image) }}" />

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
                custom-domain="{{ $settings['spektrix_custom_domain'] }}"
                membership-id="{{ $layout->membership->id }}">
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
        <div class="mb-12 lg:mb-0 max-w-sm mx-auto   text-white lg:col-span-2">

            <div class="bg-black-light pt-4 rounded">
                <h3 class="px-4 type-xs-mono mb-2 text-white">Upcoming 15–25 Film of the Week</h3>
                <ul class="divide-y divide-gray-dark border-t border-gray-dark">
                    @foreach ($layout->films_of_the_week as $film)
                    <li class="flex px-4 items-baseline gap-4 py-3 lg:py-4">
                        <span
                            class="type-xs-mono w-12 shrink-0 text-yellow">{{ $film->started ? 'Now' : 'Next' }}</span>
                        <a href="{{ $film->event->url }}" class="type-small transition hover:text-yellow">
                            {{ $film->event->name }}
                        </a>
                        <span class="type-xs-mono ml-auto whitespace-nowrap text-gray-medium">
                            {{ $film->started ? 'until ' . $film->last->format('jS M') : 'from ' . $film->first->format('jS M') }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>

<x-marquee class="!bg-sand" />