@extends('layouts.default', ['header_position' => 'static', 'header_background' => 'bg-sand', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    @include('sections.pageheader-default', ['hide_image' => true])

    <div class="flex flex-row">
        @foreach ($page->getMedia('gallery')->shuffle()->take(5) as $image)
            {!! $image->img('portrait', [
                    'class' => 'w-1/5',
                ])->toHtml() !!}
        @endforeach
    </div>
    <div class="bg-yellow py-16">
        <div class="type-h2 container max-w-6xl lg:text-center">
            {{ $page->content->banner_text }}
        </div>
    </div>
    <div x-data="{ activeSection: null }" class="lg:flex lg:flex-row">
        <div class="container flex flex-col justify-end bg-sand py-12 lg:w-1/2">
            <nav class="sticky bottom-4 max-w-xl">
                <h3 class="type-subtitle border-b border-gray-light pb-6">Jump to:</h3>
                @foreach ($page->content->flexible as $section)
                    <a x-data="{ section: '{{ Illuminate\Support\Str::of($section->attributes->title)->kebab() }}' }"
                        class="type-subtitle mb-2 flex flex-row items-center justify-between gap-2 border-b border-gray-light py-4"
                        :href="`#${section}`" @click="activeSection = section">
                        {{ $section->attributes->title }}
                        <div x-show="activeSection !== section">
                            @svg('right-chevron', 'inline-block h-8 w-8 rounded-full bg-white')
                        </div>
                        <div x-show="activeSection === section">
                            @svg('right-chevron', 'inline-block h-8 w-8 rounded-full bg-yellow')
                        </div>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="min-h-screen py-8 lg:w-1/2">

            @foreach ($page->content->flexible as $section)
                <section
                    x-intersect:enter.half="activeSection = '{{ Illuminate\Support\Str::of($section->attributes->title)->kebab() }}'"
                    id="{{ Illuminate\Support\Str::of($section->attributes->title)->kebab() }}">

                    <div class="container">
                        {!! $page->getMedia('banner_' . $section->key)->first()->img('landscape', ['class' => 'rounded-md mb-6'])->toHtml() !!}
                    </div>

                    <h2 class="type-h3 container">
                        {{ $section->attributes->title }}</h2>

                    @include('components.editorjs', [
                        'content' => json_decode($section->attributes->section_content),
                    ])
                </section>
            @endforeach
        </div>
    </div>

    @if ($page->secondaryImage)
        {!! $page->secondaryImage->img('wide', ['class' => 'w-full'])->toHtml() !!}
    @endif
@endsection