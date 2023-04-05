@extends('layouts.default', ['header_class' => 'text-white', 'logo_background' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'posts', 'resourceId' => $post->id])])
@section('title', $post->title)
@section('description', $post->introduction)

@section('content')

    <div class="bg-sand relative z-[5]">
        <div class="h-screen border-b-[1rem] border-sand-light relative bg-black">
            @if ($post->featuredImage)
                {!! $post->featuredImage->img('landscape', ['class' => 'absolute opacity-70 inset-0 h-full object-cover w-full'])->toHtml() !!}
            @endif
            <div class="lg:container text-center lg:text-left flex flex-col h-full absolute inset-0 text-white">
                <div class="my-auto">
                    <div class="type-xs-mono lg:hidden mt-16 mb-8">{{ $post->date }}</div>
                    <h1 class="type-medium xl:type-large max-w-xs lg:max-w-lg 2xl:max-w-xl mx-auto lg:mx-0">
                        {{ $post->title }}</h1>

                    <div class="justify-center mt-8 lg:hidden gap-1 flex flex-row items-center">
                        @foreach ($post->tags_translated ?? [] as $tag)
                            <span
                                class="type-xs-mono bg-gray-dark text-white rounded px-1 py-0.5">{{ $tag->name_translated }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="pb-8 lg:flex flex-row items-end">
                    <div class="lg:w-1/2">
                        <p class="mx-auto lg:mx-0 max-w-xs lg:max-w-md">{{ $post->summary }}</p>
                    </div>
                    <x-journal-postmeta class="hidden lg:block border-l border-gray container w-1/2 !text-white"
                        :dark="true" :post="$post" :link_tags="true" />
                </div>
            </div>
        </div>

        <div class="bg-sand-light container lg:ml-auto mr-0 lg:w-1/2">

            <div class="type-regular lg:type-medium max-w-xl pt-8 lg:pt-24 pb-24">
                {{ $post->introduction }}
            </div>

            <p class="type-xs-mono pb-4 whitespace-nowrap">{{ $post->user->name }}</p>

        </div>

        <x-editorjs class="pb-24" :content="$post->content" block_class="lg:w-1/2 container lg:mr-0"
            wide_class="container lg:w-3/4 lg:mr-0" fullwidth_class="w-full" />

    </div>

    @if (count($related_posts))
        <div class="sticky bottom-0 -z-10">
            <div class="transform bg-black text-white pt-6">
                <h2 class="type-xs-mono mb-2 lg:-mb-6 container">@svg('plus', 'inline-block mr-2 h-6 w-6 text-yellow') Related</h2>
                <x-journal-grid :posts="$related_posts" :dark="true" post_class="hidden first:block lg:block" />
            </div>
        </div>
    @endif

@endsection
