@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@section('content')

    @include('sections.pageheader_large')

    <div x-data="{ sectionMenuOpen: false, activeSection: null }" class="flex flex-col-reverse bg-sand lg:flex-row">
        <div :class="{ 'sticky': !sectionMenuOpen }"
            class="bottom-0 flex flex-col justify-end bg-sand-light transition lg:container hover:bg-white lg:w-1/2 lg:bg-transparent lg:py-6 lg:hover:bg-transparent">
            <div class="lg:sticky lg:bottom-4 lg:max-w-xl">
                <h3 @click="sectionMenuOpen = !sectionMenuOpen"
                    class="type-xs-mono flex cursor-pointer items-center justify-between px-4 py-6 lg:block lg:px-0 lg:py-0">
                    Jump to:
                    @svg('arrow-right', 'lg:hidden h-4 w-4 rotate-90')
                </h3>
                <nav :class="{ 'translate-y-0': sectionMenuOpen, 'translate-y-full': !sectionMenuOpen }"
                    class="fixed inset-0 z-[999] flex flex-col justify-center bg-sand text-center transition max-lg:container lg:static lg:block lg:translate-y-0 lg:text-left">

                    <button @click="sectionMenuOpen = false">
                        @svg('plus', 'absolute top-3 right-3 lg:hidden h-10 w-10 rounded-full bg-black p-2 text-white rotate-45')
                    </button>
                    <h3 class="type-xs-mono mb-4 lg:hidden">Jump to:</h3>
                    @foreach ($page->content as $layout)
                        @if ($layout->title)
                            <a @click="sectionMenuOpen = false; activeSection = section" x-data="{ section: '{{ Illuminate\Support\Str::of($layout->title)->slug() }}' }"
                                class="type-regular mb-2 flex flex-row items-center justify-center gap-2 rounded text-center transition lg:justify-between lg:bg-sand-light lg:p-4 lg:text-left lg:hover:bg-white"
                                :href="`#${section}`" :class="{ '!bg-black !text-white': activeSection == section }">
                                {!! $layout->title !!}

                                @svg('arrow-right', 'hidden lg:block inline-block h-6 w-6 text-current')

                            </a>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>

        <div class="min-h-screen pt-8 lg:w-1/2">

            @foreach ($page->content as $layout)
                <section class="container pb-8">

                    <div class="">
                        @if ($layout->banner)
                            <img class="mb-8 h-auto w-full rounded" src="{{ Storage::url($layout->banner) }}" />
                        @endif
                    </div>

                    <div x-data="{ open: null }" x-init="open = window.location.hash.replace('#', '')"
                        x-intersect:enter="activeSection = '{{ Illuminate\Support\Str::of($layout->title)->slug() }}'">
                        <h2 class="type-medium mb-8" id="{{ Illuminate\Support\Str::of($layout->title)->slug() }}">
                            {!! $layout->title !!}</h2>

                        @foreach ($layout->sectioned_content as $child_layout)
                            @include('blocks.' . $child_layout->name(), [
                                'layout' => $child_layout,
                                'dark' => false,
                            ])
                        @endforeach
                    </div>

                </section>
            @endforeach
        </div>
    </div>
@endsection
