@extends('layouts.default', ['header_background' => 'bg-sand'])
@section('title', 'Journal')
@section('content')
    <div class="container relative bg-sand pb-8">
        <div class="relative pt-16 lg:pt-32">

            <div class="mx-auto max-w-6xl">

                <h2 class="type-large mb-16">Journal</h2>

                @if ($featured_post)
                    <a href="{{ route('post.show', ['post' => $featured_post->slug]) }}"
                        class="flex flex-col gap-8 lg:flex-row lg:gap-24">
                        @if ($featured_post->featuredImage)
                            {!! $featured_post->featuredImage->img('landscape', ['class' => 'rounded lg:w-1/2 h-auto mb-auto'])->toHtml() !!}
                        @endif
                        <div class="mx-auto flex w-full flex-col justify-between lg:max-w-md">
                            <p
                                class="type-xs-mono mb-8 xl:absolute xl:bottom-0 xl:left-0 xl:mb-0 xl:origin-left xl:-rotate-90 xl:transform">
                                {{ $featured_post->created_at->format('j F Y') }}
                                @if ($featured_post->tags->count())
                                    &bullet;
                                    <x-post-tags :tags="$featured_post->tags" />
                                @endif
                            </p>
                            <div class="pb-8">
                                <p class="type-xs-mono whitespace-nowrap">Written by<br> {{ $featured_post->user->name }}</p>
                            </div>
                            <h1 class="type-regular pb-8">{{ $featured_post->title }}</h1>
                            <div class="type-large max-w-2xl">{{ $featured_post->introduction }}</div>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <livewire:posts-index :featured_post="$featured_post->id" />
@endsection
