@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.index', ['resource' => 'products'])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@section('content')
    <livewire:shop />
@endsection
