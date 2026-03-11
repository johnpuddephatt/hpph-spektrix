@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@section('content')

    @include('sections.pageheader')

    @if (
        $links = $page->content->filter(function ($item) {
            return $item instanceof App\Nova\Flexible\Layouts\TextLayout && $item->title;
        }))

        <div x-data="{ sectionMenuOpen: false, activeSection: null }" x-init="activeSection = window.location.hash.replace('#', '')">

            <div class="bg-black py-6 text-white">
                <div class="container flex flex-row justify-center gap-8">
                    <div class="type-xs-mono">Jump to:</div>
                    @foreach ($links as $layout)
                        <a @click="sectionMenuOpen = false; activeSection = section" x-data="{ section: '{{ $layout->key() }}' }" class="type-small"
                            :href="`#${section}`" :class="{ '!bg-black !text-white': activeSection == section }">
                            {!! Str::of($layout->title)->before(':') !!}

                        </a>
                    @endforeach
                </div>
            </div>
    @endif

    @if ($page->content)
        <div x-data="{ open: null }" x-init="open = window.location.hash.replace('#', '')">
            @foreach ($page->content as $layout)
                @include('blocks.' . $layout->name(), ['layout' => $layout, 'dark' => false])
            @endforeach
        </div>
    @endif
@endsection
