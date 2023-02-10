@extends('layouts.default', ['header_background' => null, 'header_position' => 'fixed', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    @include('components.home-hero')
    @include('components.home-carousel')
    @include('components.home_instances')
    @include('components.journal-featuredpost', ['featured_post' => $page->content->featured_posts[0]])
    @include('components.journal-posts', ['posts' => $page->content->posts])
@endsection
