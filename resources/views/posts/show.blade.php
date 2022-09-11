@extends('layouts.default', ['header_background' => 'bg-sand', 'edit_link' => route('nova.pages.edit', ['resource' => 'posts', 'resourceId' => $post->id])])
@section('title', $post->title)
@section('description', $post->introduction)

@section('content')
    <div class="container relative bg-sand pb-12">
        <div class="relative pt-16 lg:pt-32">

            <p class="type-label mb-8 xl:absolute xl:bottom-0 xl:left-0 xl:mb-0 xl:origin-left xl:-rotate-90 xl:transform">
                {{ $post->created_at->format('j F Y') }}
                @if ($post->tags->count())
                    &bullet;
                    <x-post-tags :tags="$post->tags" />
                @endif
            </p>
            <div class="mx-auto max-w-6xl">

                <h1 class="type-h3 lg:type-h2 xl:type-h1 mb-8 max-w-xl xl:mb-32">{{ $post->title }}</h1>

                <div
                    class="mb-8 flex origin-bottom-left flex-row items-end gap-3 lg:absolute lg:bottom-0 lg:left-full lg:mb-0 lg:-rotate-90">
                    <img class="h-auto w-12 rounded lg:w-16 lg:rotate-90" src="{!! url($post->user->avatar) !!}">
                    <p class="type-label whitespace-nowrap">{{ $post->user->name }}</p>
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
@endsection
