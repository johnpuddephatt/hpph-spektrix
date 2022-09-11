@extends('layouts.default', ['header_position' => 'absolute', 'edit_link' => route('nova.pages.edit', ['resource' => 'strands', 'resourceId' => $strand->id])])
@section('title', $strand->name)
@section('content')
    <div class="fixed inset-0 -z-10 h-[75vh] w-full overflow-hidden bg-black">
        @if ($strand->featuredImage)
            {!! $strand->featuredImage->img('landscape', ['class' => 'w-1/2 absolute h-full top-0 right-0 bottom-0 object-cover'])->toHtml() !!}
        @endif
        <div class="pointer-events-none absolute left-1/2 top-0 bottom-0 w-32 bg-gradient-to-r from-black to-transparent">
        </div>

        <div class="absolute left-1/2 top-1/2 w-1/2 max-w-sm -translate-x-1/2 -translate-y-1/2 transform 2xl:max-w-md">
            {!! $strand->logo !!}
        </div>
    </div>

    <div class="relative z-[-1] mt-[75vh]">
        <div class="absolute bottom-full left-0 right-0 z-[1] mt-auto" id="event-content">
            <div class="px-4 pt-48 pb-12 text-white 2xl:px-6">
            </div>
        </div>

        <a href="#event-content"
            class="fixed left-1/2 top-[75vh] z-10 -translate-x-1/2 transform text-5xl text-white">@svg('down-chevron', 'h-16 w-16')</a>

    </div>

    <div style="background-color: {{ $strand->color }}">
        <div class="type-h4 container max-w-6xl py-16 text-center">{{ $strand->description }}</div>
    </div>

    <div class="bg-black text-white">
        <div class="py-12">
            <h2 class="type-h5 container mb-12">What’s on</h2>

            <div class="overflow-x-auto pb-12 scrollbar-hide">
                <div class="container flex flex-row gap-4">
                    @foreach ($strand->instances as $instance)
                        @include('components.instance-card')
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    @include('components.quote', ['quote' => $strand->quote])
    @include('components.faq', ['quote' => $strand->quote])

@endsection
