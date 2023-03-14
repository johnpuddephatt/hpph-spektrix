@extends('layouts.default', ['logo_background' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    @if ($page->content)
        @foreach ($page->content as $layout)
            @include('blocks.' . $layout->name(), ['layout' => $layout])
        @endforeach
    @endif
    {{-- @include('components.home-hero')
    @include('components.home-carousel')
    @include('components.home_instances')
    <x-journal-featuredpost :featured_post="$page->content->featured_posts[0]" class="bg-sand-dark py-16" />
    @include('components.journal-posts', ['posts' => $page->content->posts]) --}}
@endsection
