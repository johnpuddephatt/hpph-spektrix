@extends('layouts.default', ['header_background' => null, 'header_position' => 'fixed', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    @include('components.home-hero')
    @include('components.home-carousel')
    @includeWhen(isset($page->content->banner), 'components.banner', ['banner' => $page->content->banner])
    @include('components.home_instances')
    @include('components.journal-posts', ['posts' => $page->content->featured_posts])
@endsection
