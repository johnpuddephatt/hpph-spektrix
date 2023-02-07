@extends('layouts.default', ['header_position' => 'fixed', 'edit_link' => route('nova.pages.edit', ['resource' => 'strands', 'resourceId' => $strand->id])])
@section('title', $strand->name)
@section('color', $strand->color)

@section('content')
    <div class="fixed inset-0 -z-10 h-[calc(100vh-1rem)] w-full overflow-hidden bg-black">
        @if ($strand->featuredVideo && $strand->featuredVideo->video_conversions)
            @php($video_conversions = json_decode($strand->featuredVideo->video_conversions))
            {!! $strand->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() !!}

            <video onplay="(function(e){e.classList.remove('opacity-0'); e.classList.add('opacity-70') })(this)"
                class="absolute inset-0 h-full w-full object-cover opacity-0" playsinline muted autoplay loop>
                @foreach ($video_conversions->{'1280x720'} as $format => $url)
                    <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                @endforeach
            </video>
        @elseif ($strand->featuredVideo)
            {!! $strand->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full opacity-70 inset-0 object-cover'])->toHtml() !!}
        @else
            {!! $strand->featuredImage->img('wide', ['class' => 'w-full absolute h-full opacity-70  inset-0 object-cover'])->toHtml() !!}
        @endif

        <div class="max-w-xs text-center absolute left-1/2 top-1/2 w-1/2 -translate-x-1/2 -translate-y-1/2 transform">
            @if ($strand->logo)
                @icon($strand->logo, 'w-full h-auto')
            @endif
            <div class="type-xs-mono absolute top-full w-full max-w-xs mx-auto mt-16" style="color: {{ $strand->color }}">
                {{ $strand->short_description }}</div>
        </div>
    </div>

    <div class="relative z-[-1] mt-[calc(100vh-1rem)]">

        <a href="#event-content" class="fixed left-1/2 bottom-12 z-10 -translate-x-1/2 transform text-5xl text-white">
            @svg('chevron-down', 'h-12 w-12')</a>

    </div>

    <div id="event-content" class="bg-yellow text-center pt-12 pb-16" style="background-color: {{ $strand->color }}">
        <div class="type-xs-mono pb-8">{{ $strand->name }}</div>

        <div class="type-medium container max-w-4xl text-center">{{ $strand->description }}</div>
    </div>

    @if ($strand->instances->count())
        <div class="bg-black text-white">
            <div class="py-16">
                <h2 class="type-xs-mono text-center container mb-2">What’s on</h2>
                <h2 style="color: {{ $strand->color }}" class="type-medium text-center container mb-12">{{ $strand->name }}
                </h2>

                <div x-data="{ swiper: null, showControls: false, showPreviousControl: true, showNextControl: true }" x-init="swiper = new Swiper($refs.container, {
                    loop: false,
                    slidesPerView: 1,
                    spaceBetween: 15,
                    centerInsufficientSlides: true,
                
                    on: {
                        progress: function() {
                            showPreviousControl = !this.isBeginning;
                            showNextControl = !this.isEnd;
                            showControls = !this.isLocked;
                        }
                    },
                
                    breakpoints: {
                        640: {
                            slidesPerView: Math.min({{ count($strand->instances) }}, 1.5),
                        },
                        768: {
                            slidesPerView: Math.min({{ count($strand->instances) }}, 2),
                
                        },
                        1024: {
                            slidesPerView: Math.min({{ count($strand->instances) }}, 3),
                        },
                        1280: {
                            slidesPerView: Math.min({{ count($strand->instances) }}, 4),
                        },
                        1536: {
                            slidesPerView: Math.min({{ count($strand->instances) }}, 4),
                        },
                    },
                })" class="mt-24 relative container max-w-none mx-auto">

                    <div class="swiper-container border-t border-gray-dark w-full overflow-hidden" x-ref="container">
                        <div class="swiper-wrapper w-full">

                            @foreach ($strand->instances as $instance)
                                <x-instance-card :layout="match (count($strand->instances)) {
                                    1 => 'extra-wide',
                                    2 => 'wide',
                                    default => 'default',
                                }" :show_strand="false" :color="$strand->color" :instance="$instance" />
                            @endforeach

                        </div>
                    </div>
                    <div class="justify-center flex flex-row gap-4 border-t border-gray-dark text-white">
                        <div x-show="showControls" class="-mt-7 bg-black border border-gray-light rounded-full">
                            <button :class="{ 'opacity-25': !showPreviousControl }" :disabled="!showPreviousControl"
                                @click="swiper.slidePrev()" class="p-2 pl-6">
                                @svg('chevron-right', 'rotate-180')
                            </button>
                            <button :class="{ 'opacity-25': !showNextControl }" :disabled="!showNextControl"
                                @click="swiper.slideNext()" class="p-2 pr-6">
                                @svg('chevron-right')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('components.featured-post', ['featured_post' => $strand->posts->first()])

    @includeWhen($strand->content->members_voices, 'components.quote', [
        'members_voices' => $strand->content->members_voices,
    ])

    @includeWhen($strand->content->more_information, 'components.faq', [
        'more_information' => $strand->content->more_information,
    ])

@endsection
