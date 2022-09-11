@extends('layouts.default', ['header_background' => 'bg-sand'])
@section('title', 'Journal')
@section('content')
    <div class="container relative bg-sand pb-8">
        <div class="relative pt-16 lg:pt-32">

            <p class="type-label mb-8 xl:absolute xl:bottom-0 xl:left-0 xl:mb-0 xl:origin-left xl:-rotate-90 xl:transform">
                {{ $featured_post->created_at->format('j F Y') }}
                @if ($featured_post->tags)
                    &bullet;
                    <x-post-tags :tags="$featured_post->tags" />
                @endif
            </p>
            <div class="mx-auto max-w-6xl">

                <h2 class="type-h1 mb-16">Journal</h2>

                <div class="flex flex-row gap-24">
                    @if ($featured_post->featuredImage)
                        {!! $featured_post->featuredImage->img('landscape', ['class' => 'rounded w-1/2 h-auto mb-auto'])->toHtml() !!}
                    @endif
                    <div class="mx-auto flex max-w-md flex-col justify-between">
                        <div class="pb-8">
                            <p class="type-label whitespace-nowrap">Written by<br> {{ $featured_post->user->name }}</p>
                        </div>
                        <h1 class="type-h3 pb-8">{{ $featured_post->title }}</h1>
                        <div class="type-large max-w-2xl">{{ $featured_post->introduction }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:posts-index />
@endsection
