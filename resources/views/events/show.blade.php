@extends('layouts.default', ['header_colour' => 'light', 'header_position' => 'default', 'edit_link' => route('nova.pages.edit', ['resource' => 'events', 'resourceId' => $event->id])]) @section('content')
    <div class="fixed inset-0 -z-10 h-[calc(100vh-1rem)] w-full overflow-hidden">
        @if ($event->featuredImage)
            {!! $event->featuredImage->img('wide', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() !!}
        @endif
    </div>

    <div class="relative z-[-1] mt-[calc(100vh-4.75rem-1rem)]">
        <div class="absolute bottom-full left-0 right-0 z-[1] mt-auto" id="event-content">
            <div class="container pt-48 pb-12 text-white">
                <h1 class="mb-4 text-6xl font-bold">{{ $event->name }}</h1>
                <div class="flex flex-row items-center gap-4">
                    <x-certificate :certificate="$event->certificate_age_guidance" />
                    <x-genres-vibes :values="$event->genres_and_vibes" />
                </div>
            </div>
        </div>

        <div class="pointer-events-none absolute bottom-full left-0 right-0 h-96 bg-gradient-to-t from-black to-transparent">
        </div>


        <a href="#event-content"
            class="fixed left-1/2 top-[calc(100vh-4rem-1rem)] z-10 -translate-x-1/2 transform text-5xl text-white">@svg('down-chevron', 'h-16 w-16')</a>

    </div>

    <div class="relative mt-[calc(100vh-4.75rem-1rem)] bg-white">

        <div class="flex flex-row">

            <div class="container relative z-30 w-1/2 py-16 pr-32">
                <div class="type-large mb-24">
                    {{ $event->long_description }}
                </div>
                <div class="flex gap-4">
                    @foreach ($event->gallery as $galleryItem)
                        {{ $galleryItem->img('wide', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() }}
                    @endforeach
                </div>

                <div class="mb-24">
                    <h3 class="type-label">Why watch?</h3>
                    <div class="mt-4 flex flex-row items-start gap-8 border-t border-gray pt-4 xl:gap-36">
                        <div class="aspect-square w-24 flex-none rounded bg-gray-light"></div>
                        <div>
                            <blockquote>
                                <p class="type-subtitle relative mb-2"><span
                                        class="absolute right-full pr-0.5">???</span>Lorem ipsum
                                    dolor sit amet consectetur, adipisicing elit.
                                    Enim
                                    mollitia a ea
                                    quas
                                    repellat eius maxime?<span class="pl-0.5">???</span>
                                </p>
                                <cite>
                                    <span class="not-italic">Ollie,</span> Marketing &amp; Communications Manager
                                </cite>
                            </blockquote>

                        </div>
                    </div>
                </div>


                <h3 class="type-label">Film details</h3>

                <div class="mt-4 divide-y divide-gray border-t border-gray">
                    <div class="flex flex-row gap-4 py-4">
                        <div class="w-56 pr-6 font-bold">Director</div>
                        <div class="flex-1">{{ $event->director }}</div>
                    </div>
                    <div class="flex flex-row gap-4 py-4">
                        <div class="w-56 pr-6 font-bold">Featuring</div>
                        <div class="flex-1">{!! implode(' &bullet; ', $event->featuring_stars) !!}</div>
                    </div>
                    <div class="flex flex-row gap-4 py-4">
                        <div class="w-56 pr-6 font-bold">Language</div>
                        <div class="flex-1">{!! implode(' &bullet; ', $event->language) !!}</div>
                    </div>
                    <div class="flex flex-row gap-4 py-4">
                        <div class="w-56 pr-6 font-bold">Country of origin</div>
                        <div class="flex-1">{!! implode(' &bullet; ', $event->country_of_origin) !!}</div>
                    </div>
                </div>
            </div>
            <div class="w-1/2 bg-sand" x-data="{ stage: 1, selectedScreening: null }">
                <div class="container relative py-16 pl-32" x-show="stage == 1">
                    <h2
                        class="type-label absolute right-full origin-right translate-x-8 -rotate-90 transform whitespace-nowrap">
                        Upcoming screenings</h2>
                    <div class="type-h4">Select a showtime</div>
                    <div class="mt-2"><strong>Venue</strong> Venue name @todo</div>

                    @foreach ($event->instances as $instance)
                        @if ($loop->index == 0 || $event->instances->get($loop->index - 1)->start->format('l d F, Y') !== $instance->start->format('l d F, Y'))
                            <h3 class="mt-8 mb-3 font-bold">
                                {{ $instance->start->format('l d F') }}</h3>
                        @endif

                        <div class="flex flex-row border-t border-gray-light py-2">
                            <div class="type-annotation rounded bg-black py-1.5 px-2.5 text-white">
                                {{ $instance->start->format('H:i') }}
                            </div>
                            <x-accessibilities :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->audio_described" />
                            <button
                                x-on:click="stage = 2; selectedScreening = '{{ filter_var($instance->id, FILTER_SANITIZE_NUMBER_INT) }}'"
                                class="ml-auto rounded bg-gray px-16 py-1 font-bold hover:bg-yellow">Tickets</button>
                        </div>
                    @endforeach

                </div>

                <div class="container relative py-16 pl-32" x-show="stage == 2">
                    <h2
                        class="type-label absolute right-full origin-right translate-x-8 -rotate-90 transform whitespace-nowrap">
                        Make your booking</h2>
                    <template x-if="stage == 2">
                        <div>
                            <iframe class="w-full" id="SpektrixIFrame" name="SpektrixIFrame"
                                :src="`https://{{ nova_get_setting('spektrix_custom_domain') }}/{{ nova_get_setting('spektrix_client_name') }}/website/ChooseSeats.aspx?EventInstanceId=${ selectedScreening }&resize=true`"></iframe>
                            <script>
                                document.getElementById('SpektrixIFrame').addEventListener('load', (e) => {
                                    console.log(e, e.eventPhase);
                                });
                            </script>
                        </div>
                    </template>
                </div>

                <div class="container bg-yellow py-6 pl-32">
                    <h2 class="type-h4 max-w-[8em]">Want to see this film for free?</h2>
                </div>

                <div class="container relative py-8 pl-32">
                    <div class="type-label absolute right-full origin-right translate-x-8 -rotate-90 transform">
                        Memberships</div>
                    <div class="max-w-xs">Become a HPPH member and receive free tickets plus loads of exclusive benefits.
                    </div>

                    @include('spektrix-components.memberships')


                </div>



            </div>

        </div>
    </div>


    @if ($event->reviews)
        <div class="relative bg-yellow text-center" x-data="{ click: false, activeSlide: 0 }"
            x-effect="if(click) { $refs[activeSlide].parentNode.scrollLeft = $refs[activeSlide].offsetLeft}; click = false;">
            <div
                class="flex w-full snap-x snap-mandatory flex-row overflow-x-auto scroll-smooth py-32 transition duration-1000 scrollbar-hide">
                @foreach ($event->reviews as $review)
                    <div class="w-full flex-shrink-0 transform snap-center opacity-0 transition duration-1000"
                        :class="activeSlide == {{ $loop->index }} ? 'opacity-100  delay-300' : ''"
                        x-ref="{{ $loop->index }}" x-intersect:enter.half="activeSlide = {{ $loop->index }}">
                        <div class="container mx-auto max-w-5xl">
                            <div class="type-h3 mb-8">{!! str_repeat('&#9733', $review['rating']) !!}</div>
                            <blockquote>
                                <p class="type-h3 mx-auto mb-16">
                                    ???{{ $review['quote'] }}???</p>
                                @if (isset($review['publication_name']))
                                    <cite class="type-large font-bold not-italic">{{ $review['publication_name'] }}
                                        @if (isset($review['url']))
                                            <a target="_blank" class="font-normal underline"
                                                href="{{ $review['url'] }}">read more</a>
                                        @endif
                                    </cite>
                                @endif
                            </blockquote>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 transform space-x-4">
                @foreach ($event->reviews as $review)
                    <button
                        class="h-2.5 w-2.5 overflow-hidden rounded-full border border-black indent-[-9999px] transition-colors duration-200 ease-out hover:bg-black hover:shadow-lg"
                        :class="{
                            'bg-black': activeSlide === {{ $loop->index }},
                            'bg-transparent': activeSlide !== {{ $loop->index }}
                        }"
                        x-on:click="click = true; activeSlide = {{ $loop->index }}">Show quote
                        {{ $loop->index + 1 }}</button>
                @endforeach
            </div>
        </div>
    @endif

    @if ($event->secondaryImage)
        <div class="sticky top-[100vh] -z-10 h-0">
            {!! $event->secondaryImage->img('wide', ['class' => 'transform -translate-y-full'])->toHtml() !!}
        </div>
        <div class="h-screen"></div>
    @endif

    <div class="h-[150vh] bg-sand"></div>
@endsection
