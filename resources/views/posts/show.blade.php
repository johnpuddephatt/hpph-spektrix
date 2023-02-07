@extends('layouts.default', ['header_background' => 'bg-sand', 'edit_link' => route('nova.pages.edit', ['resource' => 'posts', 'resourceId' => $post->id])])
@section('title', $post->title)
@section('description', $post->introduction)

@section('content')

    <div class="bg-sand pb-12 lg:container">
        <div class="relative pt-16 lg:pt-32">

            <div class="container mx-auto max-w-6xl">

                <p
                    class="type-xs-mono mb-8 xl:absolute xl:bottom-0 xl:left-0 xl:mb-0 xl:origin-left xl:-rotate-90 xl:transform">
                    {{ $post->created_at->format('j F Y') }}
                    {{-- @if ($post->tags->count())
                        &bullet;
                        <x-post-tags :tags="$post->tags" />
                    @endif --}}
                </p>

                <h1 class="type-regular lg:type-medium xl:type-large mb-8 max-w-xl xl:mb-32">{{ $post->title }}</h1>

                <div
                    class="mb-8 flex origin-bottom-left flex-row items-end gap-3 lg:absolute lg:bottom-0 lg:left-full lg:mb-0 lg:-rotate-90">
                    @if ($post->user->avatar)
                        <img class="h-auto w-12 rounded lg:w-16 lg:rotate-90" src="{!! url($post->user->avatar) !!}">
                    @endif
                    <p class="type-xs-mono whitespace-nowrap">{{ $post->user->name }}</p>
                </div>
                <div class="type-large max-w-2xl">{{ $post->introduction }}</div>

            </div>

        </div>
    </div>

    @if ($post->featuredImage)
        {!! $post->featuredImage->img('landscape', ['class' => 'w-full'])->toHtml() !!}
    @endif

    <div class="type-large">
        @include('components.editorjs', ['content' => $post->content])
    </div>

    <div class="bg-sand py-12">
        <div class="flew-row container mb-8 flex items-center justify-between gap-4">
            <h2 class="type-regular">Related posts</h2>
            <a class="type-large" href="{{ route('post.index') }}">All journal posts @svg('arrow-right', 'inline-block w-6 h-6')</a>
        </div>
        {{-- @include('components.posts-grid', ['posts' => $related_posts]) --}}

    </div>
@endsection
