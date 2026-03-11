@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@section('content')

    @include('sections.pageheader')

    @if (Str::of($page->slug)->startsWith('the-history-of') &&
            ($links = $page->content->filter(function ($item) {
                return $item instanceof App\Nova\Flexible\Layouts\TextLayout && $item->title;
            })))

        <div class="border-b border-black-light bg-black text-white" x-data="{ sectionMenuOpen: false, activeSection: null }" x-init="activeSection = window.location.hash.replace('#', '')">

            <div class="overflow-x-scroll py-6 scrollbar-hide">
                <div class="justify-center-safe flex flex-row gap-8 px-8">
                    <div class="type-xs-mono whitespace-nowrap">Jump to:</div>
                    @foreach ($links as $layout)
                        <a @click="sectionMenuOpen = false; activeSection = section" x-data="{ section: '{{ $layout->key() }}' }"
                            class="type-small whitespace-nowrap" :href="`#${section}`"
                            :class="{ '!bg-black !text-white': activeSection == section }">
                            {!! Str::of($layout->title)->before(':') !!}

                        </a>
                    @endforeach
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </div>
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
