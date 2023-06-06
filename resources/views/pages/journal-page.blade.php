@extends('layouts.default', ['header_class' => 'text-black'])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)

@section('content')
    {{-- <x-journal-indexheadercard class="" :post="$page->featured_post" /> --}}
    <div class="bg-sand-light pt-36 pb-8">
        <h1 class="type-medium lg:type-large container">Journal</h1>
    </div>
    <livewire:posts-index />
@endsection
