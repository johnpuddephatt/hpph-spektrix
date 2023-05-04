@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'seasons', 'resourceId' => $season->id])])
@section('title', $season->name)

@section('content')
    <div class="fixed inset-0 -z-10 h-[calc(100vh-1rem)] w-full overflow-hidden bg-black">
        @if ($season->featuredVideo && $season->featuredVideo->video_conversions)
            @php($video_conversions = json_decode($season->featuredVideo->video_conversions))
            {!! $season->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() !!}

            <video
                onplay="(function(e){e.previousElementSibling.classList.add('opacity-0'); e.classList.remove('opacity-0'); e.classList.add('opacity-50') })(this)"
                class="absolute inset-0 h-full w-full object-cover opacity-0" playsinline muted autoplay loop>
                @foreach ($video_conversions->{'1280x720'} as $format => $url)
                    <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                @endforeach
            </video>
        @elseif ($season->featuredVideo)
            {!! $season->featuredVideo->img('thumb', ['class' => 'w-full absolute h-full opacity-50 inset-0 object-cover'])->toHtml() !!}
        @elseif($season->featuredImage)
            {!! $season->featuredImage->img('wide', ['class' => 'w-full absolute h-full opacity-50  inset-0 object-cover'])->toHtml() !!}
        @endif

        <div class="w-full absolute text-white text-center left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 transform">
            @svg('logo-hpph-without-est', 'w-20 mb-2 mx-auto text-yellow')
            <div class="type-xs-mono mb-8 mt-1">presents</div>
            <h1 class="type-medium lg:type-large mx-auto max-w-sm">{{ $season->name }}</h1>
            <div
                class="type-xs-mono text-yellow max-w-md sm:max-w-xs absolute top-full left-1/2 -translate-x-1/2 w-full container mx-auto mt-32 md:mt-16">
                {{ $season->short_description }}</div>
        </div>
    </div>

    <div class="relative z-[-1] mt-[calc(100vh-1rem)]">

        <a href="#event-content" class="fixed left-1/2 bottom-12 z-10 -translate-x-1/2 transform text-5xl text-white">
            @svg('chevron-down', 'h-12 w-12')</a>

    </div>

    <div id="event-content" class="bg-yellow text-center pt-8 lg:pt-12 lg:pb-16 pb-24">
        <div class="type-xs-mono pb-12 lg:pb-8">{{ $season->name }}</div>
        <div class="type-regular lg:type-medium container max-w-4xl text-center">{{ $season->description }}</div>
    </div>

    @if ($season->instances->count())
        <div class="bg-black text-yellow">
            <div class="pt-24 pb-16 container">
                <p class="type-xs-mono text-white text-center container mb-2">What’s on</p>
                <h2 class="type-regular lg:type-medium text-center container mb-12">
                    {{ $season->name }}
                </h2>

                <x-instance-slider :instances="$season->instances" :layout="match (count($season->instances)) {
                    1 => 'extra-wide',
                    2 => 'wide',
                    default => 'default',
                }" :show_strand="false" />
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
