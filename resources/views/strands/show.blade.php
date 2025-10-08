@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'strands', 'resourceId' => $strand->id])])
@section('title', $strand->name)
@section('color', $strand->color)
@section('description', $strand->short_description)
@section('image', $strand->featuredImage?->getUrl('landscape'))

@section('content')
    <div class="fixed inset-0 -z-10 h-[calc(100vh-1rem)] w-full overflow-hidden bg-black">
        @if ($strand->featuredVideo && $strand->featuredVideo->video_conversions)
            @php($video_conversions = json_decode($strand->featuredVideo->video_conversions))
            {!! $strand->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() !!}

            <video
                onplay="(function(e){e.previousElementSibling.classList.add('opacity-0'); e.classList.remove('opacity-0'); e.classList.add('opacity-70') })(this)"
                class="absolute inset-0 h-full w-full object-cover opacity-0" playsinline muted autoplay loop>
                @foreach ($video_conversions->{'1280x720'} as $format => $url)
                    <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                @endforeach
            </video>
        @elseif ($strand->featuredVideo)
            {!! $strand->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full opacity-70 inset-0 object-cover'])->toHtml() !!}
        @elseif($strand->featuredImage)
            {!! $strand->featuredImage->img('landscape', ['class' => 'w-full absolute h-full opacity-70  inset-0 object-cover'])->toHtml() !!}
        @endif

        <div class="absolute left-1/2 top-1/2 w-full -translate-x-1/2 -translate-y-1/2 transform text-center">
            @if ($strand->logo)
                @icon($strand->logo, 'w-2/3 mx-auto max-w-xs h-auto')
            @endif
            <div class="type-xs-mono container absolute left-1/2 top-full mx-auto mt-32 w-full max-w-md -translate-x-1/2 sm:max-w-xs md:mt-16"
                style="color: {{ $strand->color }}">
                {{ $strand->short_description }}</div>
        </div>
    </div>

    <div class="relative z-[-1] mt-[calc(100vh-1rem)]">

        <a href="#event-content" class="fixed bottom-12 left-1/2 z-10 -translate-x-1/2 transform text-5xl text-white">
            @svg('chevron-down', 'h-12 w-12')</a>

    </div>

    <div id="event-content" class="bg-yellow pb-24 pt-8 text-center lg:pb-16 lg:pt-12"
        style="background-color: {{ $strand->color }}">
        <div class="type-xs-mono pb-12 lg:pb-8">{{ $strand->name }}</div>
        <div class="type-regular lg:type-medium container max-w-4xl text-center">{{ $strand->description }}</div>
        @if ($strand->additional_description)
            <div class="prose container mt-6 max-w-3xl text-center">{!! $strand->additional_description !!}</div>
        @endif
        @if ($strand->funders_logo)
            <img src="{{ Storage::url($strand->funders_logo) }}" alt=""
                class="mx-auto mt-6 h-auto w-auto max-w-sm px-4">
        @endif
    </div>

    @if ($entries->count())
        <div class="bg-black text-white">
            <div class="container pb-16 pt-24">
                <p class="type-xs-mono container mb-2 text-center">What’s on</p>
                <h2 style="color: {{ $strand->color }}" class="type-regular lg:type-medium container mb-12 text-center">
                    {{ $strand->name }}
                </h2>

                <x-instance-slider :type="$strand->display_type" :entries="$entries" :layout="match ($entries->count()) {
                    1 => 'extra-wide',
                    2 => 'wide',
                    default => 'default',
                }" :color="$strand->color"
                    :show_strand="false" />
            </div>
        </div>
    @endif

    @if ($strand->content)
        <div class="bg-black">
            @foreach ($strand->content as $layout)
                @include('blocks.' . $layout->name(), ['layout' => $layout, 'dark' => true])
            @endforeach
        </div>
    @endif

@endsection
