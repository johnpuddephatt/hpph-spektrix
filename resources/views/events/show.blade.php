@extends('layouts.default', ['header_position' => 'fixed', 'edit_link' => route('nova.pages.edit', ['resource' => 'events', 'resourceId' => $event->id])])
@section('title', $event->name)
@section('content')
    <div x-data="{ trailerOpen: false, trailerLoaded: false }" class="fixed flex items-center inset-0 z-[-1] h-screen w-full overflow-hidden bg-black">

        @if ($event->featuredVideo && $event->featuredVideo->video_conversions)
            @php($video_conversions = json_decode($event->featuredVideo->video_conversions))
            {!! $event->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() !!}

            <video onplay="(function(e){e.classList.remove('opacity-0'); e.classList.add('opacity-70') })(this)"
                class="absolute inset-0 h-full w-full object-cover opacity-0" playsinline muted autoplay loop>
                @foreach ($video_conversions->{'1280x720'} as $format => $url)
                    <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                @endforeach
            </video>
        @elseif ($event->featuredVideo)
            {!! $event->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full opacity-70 inset-0 object-cover'])->toHtml() !!}
        @else
            {!! $event->featuredImage->img('wide', ['class' => 'w-full absolute h-full opacity-70  inset-0 object-cover'])->toHtml() !!}
        @endif

        <div class="md:ml-[50%] relative z-10">
            <div class="container pt-48 pb-12 text-white 2xl:px-6">
                <h1 class="type-medium md:type-large mb-1 font-bold">{{ $event->name }}</h1>

                <div class="flex flex-row items-center gap-2">
                    <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
                    <div class="type-xs-mono">{{ $event->status }}</div>
                </div>

                @if ($event->trailerEmbed)
                    <button x-on:click="trailerLoaded = true; trailerOpen = true;"
                        class="type-xs-mono leading-none cursor-pointer transition rounded-full pr-4 hover:bg-black-light hover:bg-opacity-75 mt-6 flex flex-row gap-2 items-center">
                        @svg('play', 'align-middle bg-black rounded-full h-10 w-10 p-3 text-white')
                        Play trailer
                    </button>
                @endif

            </div>
        </div>
        @if ($event->trailerEmbed)
            <template x-if="trailerLoaded && trailerOpen">
                <div x-transition x-show="trailerOpen" class="z-30 absolute inset-0 bg-black bg-opacity-80">
                    <div class="max-w-5xl w-full absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">

                        <div class="relative shadow-black-light shadow-2xl"
                            style="padding-top: {{ $event->trailerEmbed['ratio'] }}%">
                            {!! $event->trailerEmbed['html'] !!}
                        </div>

                        <button x-on:click="trailerOpen = false"
                            class="type-xs-mono text-white mx-auto leading-none cursor-pointer transition rounded-full pr-4 hover:bg-black-light hover:bg-opacity-75 mt-6 flex flex-row gap-2 items-center">
                            @svg('plus', 'rotate rotate-45 text-white w-10 h-10 p-3 bg-black rounded-full') Close trailer
                        </button>

                    </div>
                </div>
            </template>
        @endif
    </div>

    <div class="relative mt-[calc(100vh-4.75rem)] bg-black pb-12">

        <div class="border-t-8 border-yellow gap-8 bg-sand flex flex-row pb-12 relative mt-[calc(100vh-4.25rem-1rem)]">
            <div class="container w-1/2 flex-1 flex flex-col justify-end">
                <x-why-watch />
                <x-journal-featuredpost-mini :post="$event->latest_post->count() ? $event->latest_post->first() : null" />
            </div>
            <div class="relative lg:w-1/2">
                <div class="bg-yellow p-6">
                    <div class="type-medium py-20 max-w-2xl">

                        {!! $event->description !!}
                    </div>
                    <x-genres-vibes-badge :values="$event->genres_and_vibes" />
                </div>

                @foreach ($event->strands as $strand)
                    <x-strand-strip :strand="$strand" />
                @endforeach

                <div class="max-w-4xl lg:pr-16 xl:pr-32">

                    <div class="prose mt-12 mb-24">
                        {{ $event->long_description }}
                    </div>

                    <div class="container">
                        <h3 class="type-xs-mono">Film details</h3>

                        <div class="mt-4 divide-y divide-gray border-t border-gray">
                            <x-details-row label="Duration" :value="$event->duration" />
                            <x-details-row label="Director" :value="$event->director" />
                            <x-details-row label="Featuring" :value="implode(' &bullet; ', $event->featuring_stars)" />
                            <x-details-row label="Format" :value="$event->format" />
                            <x-details-row label="Language" :value="implode(' &bullet; ', $event->language)" />
                            <x-details-row label="Country of origin" :value="implode(' &bullet; ', $event->country_of_origin)" />
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <x-gallery :images="$event->gallery" />
        <button
            class="type-regular sticky bottom-0 flex flex-row justify-between text-left pl-[calc(50%+1.5rem)] pr-6 py-5 items-center bg-yellow w-full"
            @click="$dispatch('booking', { eventID: '{{ $event->id }}', venue: '{{ $event->venue }}'  })">
            See
            showtimes @svg('arrow-right', 'h-8 w-8 p-2 text-yellow bg-black rounded-full')</button>
        <x-reviews :reviews="$event->reviews" />
        @foreach ($event->strands as $strand)
            <x-strand-card :strand="$strand" />
        @endforeach
    </div>

@endsection
