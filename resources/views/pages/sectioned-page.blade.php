@extends('layouts.default', ['logo_background' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')

    @include('sections.pageheader_large')

    <div x-data="{ sectionMenuOpen: false, activeSection: null }" class="flex flex-col-reverse lg:flex-row bg-sand">
        <div :class="{ 'sticky': !sectionMenuOpen }"
            class="bg-sand-light lg:bg-transparent bottom-0 lg:container flex flex-col justify-end hover:bg-white transition lg:hover:bg-transparent lg:py-6 lg:w-1/2">
            <div class="lg:sticky lg:bottom-4 lg:max-w-xl">
                <h3 @click="sectionMenuOpen = !sectionMenuOpen"
                    class="type-xs-mono px-4 lg:px-0 lg:py-0 py-6 cursor-pointer lg:block flex items-center justify-between">
                    Jump to:
                    @svg('arrow-right', 'lg:hidden h-4 w-4 rotate-90')
                </h3>
                <nav :class="{ 'translate-y-0': sectionMenuOpen, 'translate-y-full': !sectionMenuOpen }"
                    class="max-lg:container text-center lg:text-left flex flex-col justify-center z-[999] fixed bg-sand inset-0 transition lg:translate-y-0 lg:static lg:block">

                    <button @click="sectionMenuOpen = false">
                        @svg('plus', 'absolute top-3 right-3 lg:hidden h-10 w-10 rounded-full bg-black p-2 text-white rotate-45')
                    </button>
                    <h3 class="type-xs-mono mb-4 lg:hidden">Jump to:</h3>
                    @foreach ($page->content as $layout)
                        <a @click="sectionMenuOpen = false" x-data="{ section: '{{ Illuminate\Support\Str::of($layout->title)->kebab() }}' }"
                            class="type-regular text-center lg:text-left mb-2 flex flex-row items-center justify-center lg:justify-between gap-2 lg:bg-sand-light lg:hover:bg-white transition rounded lg:p-4"
                            :href="`#${section}`" @click="activeSection = section">
                            {{ $layout->title }}

                            @svg('arrow-right', 'hidden lg:block inline-block h-6 w-6 text-black')

                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        <div class="min-h-screen py-8 lg:w-1/2">

            @foreach ($page->content as $layout)
                <section
                    x-intersect:enter.half="activeSection = '{{ Illuminate\Support\Str::of($layout->title)->kebab() }}'"
                    id="{{ Illuminate\Support\Str::of($layout->title)->kebab() }}">

                    <div class="container">
                        @if ($layout->banner)
                            <x-image class="rounded w-full mb-8 h-auto" width="30rem" :src="Storage::url($layout->banner)" />
                        @endif
                    </div>

                    <h2 class="type-medium container">
                        {{ $layout->title }}</h2>

                    <x-editorjs block_class="my-8 container" :content="json_decode($layout->section_content)" />

                </section>
            @endforeach
        </div>
    </div>
@endsection
