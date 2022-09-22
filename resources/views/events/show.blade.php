@extends('layouts.default', ['header_position' => 'absolute', 'edit_link' => route('nova.pages.edit', ['resource' => 'events', 'resourceId' => $event->id])])
@section('title', $event->name)
@section('content')
    <div class="fixed inset-0 -z-10 h-[calc(100vh-1rem)] w-full overflow-hidden">
        @if ($event->featuredImage)
            {!! $event->featuredImage->img('wide', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() !!}
        @endif
    </div>

    <div class="relative mt-[calc(100vh-4.25rem-1rem)]">
        <div class="absolute bottom-full left-0 right-0 z-[1] mt-auto" id="event-content">
            <div class="px-4 pt-48 pb-12 text-white 2xl:px-6">
                <h1 class="mb-4 text-6xl font-bold">{{ $event->name }}</h1>
                <div class="flex flex-row items-center gap-2">
                    <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
                    @foreach ($event->strands as $strand)
                        <x-strand-badge :strand="$strand" />
                    @endforeach
                    @if (count($event->genres_and_vibes))
                        &bullet;
                    @endif
                    <x-genres-vibes-badge :values="$event->genres_and_vibes" />
                </div>
            </div>
        </div>

        <div class="fade-to-top pointer-events-none absolute bottom-full left-0 right-0 h-72">

            <a href="#event-content"
                class="fixed left-1/2 top-[calc(100vh-4rem-1rem)] z-10 -translate-x-1/2 transform text-5xl text-white">@svg('down-chevron', 'h-16 w-16')</a>

        </div>

        <div class="relative mt-[calc(100vh-4.25rem-1rem)] bg-white">

            <div class="flex-row justify-between lg:flex">

                <div class="relative z-30 ml-0 max-w-4xl py-16 lg:w-1/2 lg:pr-32">
                    <div class="type-large prose mb-24">
                        {{ $event->long_description }}
                    </div>
                    <!-- <div class="flex gap-4">
                                                            @foreach ($event->gallery as $galleryItem)
    {{ $galleryItem->img('wide', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() }}
    @endforeach
                                                        </div> -->

                    <div class="container mb-24">
                        <h3 class="type-label">Why watch?</h3>
                        <div class="mt-4 flex flex-row items-start gap-8 border-t border-gray pt-4 xl:gap-36">
                            <div class="aspect-square w-24 flex-none rounded bg-gray-light"></div>
                            <div>
                                <blockquote>
                                    <p class="type-subtitle relative mb-2"><span
                                            class="absolute right-full pr-0.5">“</span>Lorem ipsum
                                        dolor sit amet consectetur, adipisicing elit.
                                        Enim
                                        mollitia a ea
                                        quas
                                        repellat eius maxime?<span class="pl-0.5">”</span>
                                    </p>
                                    <cite>
                                        <span class="not-italic">Ollie,</span> Marketing &amp; Communications Manager
                                    </cite>
                                </blockquote>

                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <h3 class="type-label">Film details</h3>

                        <div class="mt-4 divide-y divide-gray border-t border-gray">
                            <x-details-row label="Director" :value="$event->director" />
                            <x-details-row label="Featuring" :value="implode(' &bullet; ', $event->featuring_stars)" />
                            <x-details-row label="Language" :value="implode(' &bullet; ', $event->language)" />
                            <x-details-row label="Country of origin" :value="implode(' &bullet; ', $event->country_of_origin)" />
                        </div>
                    </div>
                </div>
                <div class="bg-sand lg:min-h-screen lg:w-1/2" x-data="{ stage: 1, selectedScreening: null, iFrameLoading: true }">
                    <div class="container relative py-16 pl-24 lg:pl-32" x-show="stage == 1">
                        <h2
                            class="type-label absolute right-full origin-right translate-x-8 -rotate-90 transform whitespace-nowrap">
                            Upcoming screenings</h2>
                        <div class="type-h5">Select a showtime</div>

                        @if ($event->instances->count())
                            <div class="mt-2"><strong>Venue</strong> {{ $event->venue }}</div>

                            @foreach ($event->instances as $instance)
                                @if ($loop->index == 0 ||
                                    $event->instances->get($loop->index - 1)->start->format('l d F, Y') !== $instance->start->format('l d F, Y'))
                                    <h3 class="mt-8 mb-3 font-bold">
                                        {{ $instance->start->format('l d F') }}</h3>
                                @endif

                                <div class="flex max-w-xl flex-row items-center gap-2 border-t border-gray-light py-2">
                                    <div class="type-annotation rounded bg-black py-1.5 px-2.5 text-white">
                                        {{ $instance->start->format('H:i') }}
                                    </div>
                                    <x-strand :strand="$instance->strand" />
                                    <x-accessibilities :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->audio_described" />
                                    <button
                                        x-on:click="stage = 2; selectedScreening = '{{ filter_var($instance->id, FILTER_SANITIZE_NUMBER_INT) }}'"
                                        class="ml-auto rounded bg-gray px-16 py-1 font-bold hover:bg-yellow">Tickets</button>
                                </div>
                            @endforeach
                        @else
                            <div class="mt-12 max-w-md rounded bg-gray py-16 text-center">
                                {!! $settings['no_scheduled_screenings'] ?? 'No scheduled screenings' !!}
                            </div>
                        @endif

                    </div>

                    <div class="container relative py-16 pl-32" x-show="stage == 2">
                        <h2
                            class="type-label absolute right-full origin-right translate-x-8 -rotate-90 transform whitespace-nowrap">
                            Make your booking</h2>
                        <template x-if="stage == 2">
                            <div class="max-w-xl">
                                <div x-show="iFrameLoading" x-transition class="absolute inset-0 bg-sand py-16 pl-32">
                                    @svg('loading', 'w-32 ml-36 block pt-24 text-sand-dark')

                                </div>
                                <iframe x-on:load="iFrameLoading = false" class="h-96 w-full transition-all"
                                    id="SpektrixIFrame" name="SpektrixIFrame"
                                    :src="`https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/ChooseSeats.aspx?EventInstanceId=${ selectedScreening }&resize=true`"></iframe>
                            </div>
                        </template>
                    </div>

                    @if ($event->instances->count())
                        <div class="container bg-yellow py-6 pl-32">
                            <h2 class="type-h5 max-w-[8em]">Want to see this film for free?</h2>
                        </div>

                        <div class="container relative max-w-xl py-8 pl-32">
                            <div class="type-label absolute right-full origin-right translate-x-8 -rotate-90 transform">
                                Memberships</div>
                            <div class="max-w-xs">Become a HPPH member and receive free tickets plus loads of exclusive
                                benefits.
                            </div>

                            @include('spektrix-components.memberships')
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @foreach ($event->strands as $strand)
            <x-strand-card :strand="$strand" />
        @endforeach

        <x-reviews :reviews="$event->reviews" />

        @if ($event->secondaryImage)
            <div class="sticky top-[100vh] -z-10 h-0">
                {!! $event->secondaryImage->img('wide', ['class' => 'w-full h-screen object-cover transform -translate-y-full'])->toHtml() !!}
            </div>
            <div class="h-screen"></div>
        @endif

        <x-journal-posts :posts="$event->posts" />

    @endsection
