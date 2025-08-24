@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'seasons', 'resourceId' => $season->id])])
@section('title', $season->name)
@section('color', '#ffda3d')

@section('description', $season->short_description)
@section('image', $season->featuredImage?->getUrl('landscape'))

{{-- @php($opacity = $season->hpph_presents || $season->show_header ? 'opacity-50' : 'opacity-100') --}}
@php($opacity = 'opacity-60')
@section('content')
    <div class="fixed inset-0 -z-10 h-[calc(100vh-1rem)] w-full overflow-hidden bg-black">
        @if ($season->featuredVideo && $season->featuredVideo->video_conversions)
            @php($video_conversions = json_decode($season->featuredVideo->video_conversions))
            {!! $season->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() !!}

            <video
                onplay="(function(e){e.previousElementSibling.classList.add('opacity-0'); e.classList.remove('opacity-0'); e.classList.add($opacity) })(this)"
                class="absolute inset-0 h-full w-full object-cover opacity-0" playsinline muted autoplay loop>
                @foreach ($video_conversions->{'1280x720'} as $format => $url)
                    <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                @endforeach
            </video>
        @elseif ($season->featuredVideo)
            {!! $season->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full ' . $opacity . ' inset-0 object-cover'])->toHtml() !!}
        @elseif($season->featuredImage)
            {!! $season->featuredImage->img('landscape', ['class' => 'w-full absolute h-full ' . $opacity . ' inset-0 object-cover'])->toHtml() !!}
        @endif

        <div class="absolute left-1/2 top-1/2 w-full -translate-x-1/2 -translate-y-1/2 transform text-center text-white">

            @if ($season->hpph_presents)
                @svg('logo-hpph-without-est', 'w-20 mb-2 mx-auto text-yellow')
                <div class="type-xs-mono mb-8 mt-1">presents</div>
            @endif

            @if ($season->hero_overlay_image)
                <img src="{{ Storage::url($season->hero_overlay_image) }}" alt="{{ $season->name }}"
                    class="mx-auto mb-32 w-[48rem] max-w-full">
            @else
                @if ($season->show_header)
                    <h1 class="type-medium lg:type-large mx-auto max-w-sm">{{ $season->name }}</h1>
                    <div
                        class="type-xs-mono container absolute left-1/2 top-full mx-auto mt-32 w-full max-w-md -translate-x-1/2 text-yellow sm:max-w-xs md:mt-16">
                        {{ $season->short_description }}</div>
                @endif
            @endif
        </div>
    </div>

    <div class="relative z-[-1] mt-[calc(100vh-1rem)]">

        <a href="#event-content" class="fixed bottom-12 left-1/2 z-10 -translate-x-1/2 transform text-5xl text-white">
            @svg('chevron-down', 'h-12 w-12')</a>

    </div>

    <div id="event-content" class="bg-yellow pb-24 pt-8 text-center lg:pb-16 lg:pt-12">
        <div class="type-xs-mono pb-12 lg:pb-8">{{ $season->name }}</div>
        <div class="type-regular lg:type-medium container max-w-4xl text-center">{{ $season->description }}</div>
        @if ($season->additional_description)
            <div class="prose container mt-6 max-w-3xl text-center">{{ $season->additional_description }}</div>
        @endif
        @if ($season->funders_logo)
            <img onload="this.style.width = this.clientWidth/2 + 'px'; this.classList.add('max-w-sm'); this.classList.remove('opacity-0')"
                src="{{ Storage::url($season->funders_logo) }}" alt=""
                class="mx-auto mt-8 h-auto w-auto px-4 opacity-0">
        @endif
    </div>

    @if ($entries->count())
        <div class="bg-black text-yellow">
            <div class="container pb-16 pt-24">
                <p class="type-xs-mono container mb-2 text-center text-white">What’s on
                </p>
                <h2 class="type-regular lg:type-medium container mb-12 text-center">
                    {{ $season->name }}
                </h2>

                <x-instance-slider :type="$season->display_type" :entries="$entries" color="#f2d13c" :layout="match ($entries->count()) {
                    1 => 'extra-wide',
                    2 => 'wide',
                    default => 'default',
                }"
                    :show_strand="false" />
            </div>
        </div>
    @endif

    @if ($season->content)
        <div class="bg-black">
            @foreach ($season->content as $layout)
                @include('blocks.' . $layout->name(), ['layout' => $layout, 'dark' => true])
            @endforeach
        </div>
    @endif

@endsection
