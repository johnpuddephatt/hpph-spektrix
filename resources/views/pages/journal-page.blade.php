@extends('layouts.default', ['header_class' => 'text-white lg:text-black'])

@section('title', $page->seo_title ?? $page->title)
@section('description', $page->seo_description ?? $page->introduction)

@section('content')
    <x-journal-indexheadercard class="" :post="$page->featured_post" />
    <livewire:posts-index :featured_post="$page->featured_post->id" />
@endsection
