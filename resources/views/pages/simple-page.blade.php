@extends('layouts.default', ['header_background' => 'bg-sand', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    @include('sections.pageheader-text')

    <div class="type-large my-16">
        <div class="container max-w-6xl">
            <p class="type-medium mb-8 max-w-2xl">{{ $page->introduction }}</p>
        </div>

        @foreach ($page->content->blocks as $block)
            @includeIf('vendor.nova-editor-js.' . $block->type, (array) $block->data)
        @endforeach
    </div>
@endsection
