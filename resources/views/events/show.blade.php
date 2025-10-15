@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'events', 'resourceId' => $event->id])])
@section('title', $event->name)
@section('description', strip_tags($event->description))
@section('image', $event->featuredImage?->getUrl('wide'))

@section('content')
    <div x-data="{ trailerOpen: false, trailerLoaded: false }" x-init="if (window.location.hash) {
        $dispatch('booking', { instanceID: window.location.hash.substring(1), eventID: '{{ $event->id }}', event: '{{ htmlentities($event->name, ENT_QUOTES) }}', certificate: '{{ htmlentities($event->certificate_age_guidance, ENT_QUOTES) }}' })
    }"
        class="fixed inset-0 z-[-1] flex h-screen w-full items-center overflow-hidden bg-black">

        @if ($event->featuredVideo && $event->featuredVideo->video_conversions)
            @php($video_conversions = json_decode($event->featuredVideo->video_conversions))
            {!! $event->featuredVideo->img('thumb', ['class' => 'transition w-full opacity-50 absolute h-full inset-0 object-cover'])->toHtml() !!}

            <video
                onplay="(function(e){e.previousElementSibling.classList.remove('opacity-50'); e.previousElementSibling.classList.add('opacity-0'); e.classList.remove('opacity-0'); e.classList.add('opacity-70') })(this)"
                class="absolute inset-0 h-full w-full object-cover opacity-0 transition" playsinline muted autoplay loop>
                @foreach ($video_conversions->{'1280x720'} as $format => $url)
                    <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                @endforeach
            </video>
        @elseif ($event->featuredVideo)
            {!! $event->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full opacity-70 inset-0 object-cover'])->toHtml() !!}
        @elseif($event->featuredImage)
            {!! $event->featuredImage->img('wide', ['class' => 'w-full absolute h-full opacity-70  inset-0 object-cover'])->toHtml() !!}
        @endif

        <div class="relative z-10 lg:ml-[50%]">
            <div class="container pt-12 text-white 2xl:px-6">
                <h1 class="type-medium md:type-large mb-1 max-w-xl font-bold">{{ $event->name }}
                    <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
                </h1>

                @if ($event->subtitle)
                    <div class="type-regular !font-normal">{{ $event->subtitle }}</div>
                @endif

                <div class="mt-4 flex flex-row items-center gap-2">
                    <div class="type-xs-mono">{!! $event->date_range !!}</div>
                </div>

                @if ($event->trailerEmbed)
                    <button x-on:click="trailerLoaded = true; trailerOpen = true;"
                        class="type-xs-mono mt-6 flex cursor-pointer flex-row items-center gap-2 rounded-full pr-4 leading-none transition hover:bg-black-light hover:bg-opacity-75">
                        @svg('play', 'align-middle bg-black rounded-full h-10 w-10 p-3 text-white')
                        Play trailer
                    </button>
                @endif

            </div>
        </div>
        @if ($event->trailerEmbed)
            <template x-if="trailerLoaded && trailerOpen">
                <div x-transition x-show="trailerOpen" class="absolute inset-0 z-30 bg-black bg-opacity-80">
                    <div class="absolute left-1/2 top-1/2 w-full max-w-5xl -translate-x-1/2 -translate-y-1/2 transform">

                        <div class="relative shadow-2xl shadow-black-light"
                            style="padding-top: {{ $event->trailerEmbed['ratio'] }}%">
                            {!! $event->trailerEmbed['html'] !!}
                        </div>

                        <button x-on:click="trailerOpen = false"
                            class="type-xs-mono mx-auto mt-6 flex cursor-pointer flex-row items-center gap-2 rounded-full pr-4 leading-none text-white transition hover:bg-black-light hover:bg-opacity-75">
                            @svg('plus', 'rotate rotate-45 text-white w-10 h-10 p-3 bg-black rounded-full') Close trailer
                        </button>

                    </div>
                </div>
            </template>
        @endif
    </div>

    <div class="mt-screen-minus-bar relative bg-black pb-12">

        <div
            class="mt-screen-minus-bar-minus-one relative flex flex-col-reverse gap-8 border-t-8 border-yellow bg-sand pb-12 lg:flex-row">
            <div class="container flex flex-1 flex-col justify-end max-lg:pl-0 lg:w-1/2">
                <x-event-why-watch :why_watch="$event->why_watch" />
                <x-journal-featuredpost-mini :post="$event->latest_post->count() ? $event->latest_post->first() : null" />
                <x-related-event :event="$event->related_event" />
            </div>
            <div class="relative lg:w-1/2">
                <div class="bg-yellow px-4 py-6">
                    <div class="type-regular lg:type-medium max-w-xl py-20">
                        {!! $event->description !!}
                    </div>

                    <div class="flex max-w-xl items-center justify-between gap-4">
                        <x-genres-vibes-badge :values="$event->genres_and_vibes" />
                        @if (($event->f_rating == 'F-Rated' || $event->f_rating == 'Triple F-Rating') && nova_get_setting('f_rating_info'))
                            <a href="{{ nova_get_setting('f_rating_info') }}" target="_blank">
                                @if ($event->f_rating == 'F-Rated')
                                    <img src="{{ asset('single-f-rated.png') }}" alt="F-Rated" title="F-Rated"
                                        class="mx-auto h-auto w-12" />
                                @elseif($event->f_rating == 'Triple F-Rating')
                                    <img src="{{ asset('triple-f-rated.png') }}" alt="Triple F-Rated"
                                        title="Triple F-Rated" class="mx-auto h-auto w-12" />
                                @endif
                                <div class="type-xs-mono mt-1 text-center underline">Learn more</div>
                            </a>
                        @endif
                    </div>
                </div>

                @foreach ($event->strands as $strand)
                    <x-strand.strip :strand="$strand" />
                @endforeach
                <x-season.strip :season="$event->season" />

                <div class="max-w-4xl lg:pr-16 xl:pr-32">

                    <div class="prose container mb-24 mt-12">
                        <x-editorjs :content="$event->long_description" />
                    </div>

                    <div class="container">
                        <h3 class="type-xs-mono">Details</h3>

                        <div class="mt-4 divide-y divide-sand-dark border-t border-sand-dark">
                            <x-details-row label="Original language title" :value="$event->original_language_title" />
                            <x-details-row label="Duration" :value="$event->duration" />
                            <x-details-row label="Director" :value="$event->director" />
                            <x-details-row label="Distributor" :value="$event->distributor" />
                            <x-details-row label="Featuring" :value="implode(' &bullet; ', $event->featuring_stars)" />
                            <x-details-row label="Year" :value="$event->year_of_production" />
                            <x-details-row label="Country of origin" :value="implode(' &bullet; ', $event->country_of_origin)" />
                            <x-details-row label="Language" :value="implode(' &bullet; ', $event->language)" />
                            <x-details-row label="Format" :value="$event->format" />
                            <x-details-row label="Strobe lighting" :value="$event->strobe_light_warning ?: $settings['strobe_light_warning_unavailable']" />
                            @if (!$event->content_guidance)
                                <x-details-row label="Content guidance" :value="$settings['content_guidance_unavailable'] ??
                                    'No content guidance is available'" />
                            @elseif (in_array(implode(',', $event->content_guidance), $settings['content_warnings_to_not_hide']))
                                <x-details-row label="Content guidance" :value="implode(',', $event->content_guidance)" />
                            @else
                                <x-details-row-masked label="Content guidance" :value="implode(' &bullet; ', $event->content_guidance)" />
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <x-event-reviews :reviews="$event->reviews" />

        {{-- <x-strand.card :strand="$event->strand" />
        <x-season.card :season="$event->season" /> --}}

        @if ($event->strand)
            <div class="container mb-8 mt-0">
                <x-instance-slider :layout="match (count($strand_related) + 1) {
                    1 => 'extra-wide',
                    2 => 'wide',
                    default => 'default',
                }" :strand="$event->strand" :color="$event->strand->color" :show_strand="false"
                    :entries="$strand_related" :type="$event->strand->display_type" />
            </div>
        @endif
        @if ($event->season)
            <div class="container my-8">
                <x-instance-slider :layout="match (count($season_related) + 1) {
                    1 => 'extra-wide',
                    2 => 'wide',
                    default => 'default',
                }" x-show="count($season_related)" color="#FFDA3D" :season="$event->season"
                    :show_strand="false" :type="$event->season->display_type" :entries="$season_related" />
            </div>
        @endif

        @if ($event->coming_soon)
            <div class="sticky bottom-0 z-10 block w-full bg-yellow py-5">

                <div class="container flex flex-row items-center">
                    <div class="hidden w-1/2 lg:block">
                        @svg('plus', 'h-6 w-6')
                    </div>
                    <div class="type-regular lg:px-4">
                        Showtimes & tickets available soon
                    </div>
                </div>
            </div>
        @elseif($event->date_range)
            <button class="sticky bottom-0 z-10 block w-full bg-yellow py-4"
                @click="$dispatch('booking', { eventID: '{{ $event->id }}', event: '{{ htmlentities($event->name, ENT_QUOTES) }}', instanceID: null, certificate: '{{ htmlentities($event->certificate_age_guidance, ENT_QUOTES) }}' })">
                <div class="container flex flex-row items-center">
                    <div class="hidden w-1/2 lg:block">
                        @svg('plus', 'h-6 w-6')
                    </div>
                    <div class="type-regular lg:px-4">
                        {!! $settings['showtimes_link'] ?? 'See showtimes &amp; book' !!}
                    </div> @svg('arrow-right', 'ml-auto h-8 w-8 p-2 text-yellow bg-black rounded-full')
                </div>
            </button>
        @else
            <div class="sticky bottom-0 z-10 block w-full bg-yellow py-5">

                <div class="container flex flex-row items-center">
                    <div class="hidden w-1/2 lg:block">
                        @svg('plus', 'h-6 w-6')
                    </div>
                    <div class="type-regular lg:px-4">
                        No screenings scheduled
                    </div>
                </div>
            </div>
        @endif

        <x-gallery :images="$event->gallery" />

    </div>

@endsection
