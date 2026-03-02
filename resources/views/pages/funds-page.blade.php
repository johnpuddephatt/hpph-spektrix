@extends('layouts.default', ['header_class' => 'text-white lg:text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@push('webComponents', '#spektrix-donate')

@section('content')
    @include('sections.pageheader_alternative')
    <div class="bg-sand pb-16">

        @foreach ($page->content as $layout)
            @include('blocks.' . $layout->name(), ['layout' => $layout, 'dark' => false])
        @endforeach
    </div>
@endsection
