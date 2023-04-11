@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'strands', 'resourceId' => $strand->id])])
@section('title', $strand->name)
@section('color', $strand->color)

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
            {!! $strand->featuredImage->img('wide', ['class' => 'w-full absolute h-full opacity-70  inset-0 object-cover'])->toHtml() !!}
        @endif

        <div class="w-full absolute text-center left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 transform">
            @if ($strand->logo)
                @icon($strand->logo, 'w-2/3 mx-auto max-w-xs h-auto')
            @endif
            <div class="type-xs-mono max-w-md sm:max-w-xs absolute top-full left-1/2 -translate-x-1/2 w-full container mx-auto mt-32 md:mt-16"
                style="color: {{ $strand->color }}">
                {{ $strand->short_description }}</div>
        </div>
    </div>

    <div class="relative z-[-1] mt-[calc(100vh-1rem)]">

        <a href="#event-content" class="fixed left-1/2 bottom-12 z-10 -translate-x-1/2 transform text-5xl text-white">
            @svg('chevron-down', 'h-12 w-12')</a>

    </div>

    <div id="event-content" class="bg-yellow text-center pt-8 lg:pt-12 lg:pb-16 pb-24"
        style="background-color: {{ $strand->color }}">
        <div class="type-xs-mono pb-12 lg:pb-8">{{ $strand->name }}</div>
        <div class="type-regular lg:type-medium container max-w-4xl text-center">{{ $strand->description }}</div>
    </div>

    @if ($strand->instances->count())
        <div class="bg-black text-white">
            <div class="pt-24 pb-16 container">
                <p class="type-xs-mono text-center container mb-2">What’s on</p>
                <h2 style="color: {{ $strand->color }}" class="type-regular lg:type-medium text-center container mb-12">
                    {{ $strand->name }}
                </h2>

                <x-instance-slider :instances="$strand->instances" :layout="match (count($strand->instances)) {
                    1 => 'extra-wide',
                    2 => 'wide',
                    default => 'default',
                }" :color="$strand->color" :show_strand="false" />
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
