@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@section('content')

    @include('sections.pageheader')

    {{--
    
    Need to add a title field to all blocks for this to work.
    Not all blocks need title, but without one they can't appear in nav.
    We should also use layout->key I think for ID/#anchor.
    
    <div class="bg-black py-6 text-white">
        <div class="container flex flex-row justify-center gap-4">
            <div class="type-xs-mono">On this page:</div>
            @foreach ($page->content as $layout)
                @if ($layout->title)
                    <a @click="sectionMenuOpen = false; activeSection = section" x-data="{ section: '{{ Illuminate\Support\Str::of($layout->title)->slug() }}' }" class="type-small"
                        :href="`#${section}`" :class="{ '!bg-black !text-white': activeSection == section }">
                        {!! $layout->title !!}

                    </a>
                @endif
            @endforeach
        </div>
    </div> --}}

    @if ($page->content)
        <div x-data="{ open: null }" x-init="open = window.location.hash.replace('#', '')">
            @foreach ($page->content as $layout)
                @include('blocks.' . $layout->name(), ['layout' => $layout, 'dark' => false])
            @endforeach
        </div>
    @endif
@endsection
