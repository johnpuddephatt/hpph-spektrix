@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')

    @include('sections.pageheader_large')

    @if ($page->content)
        @foreach ($page->content as $layout)
            @include('blocks.' . $layout->name(), ['layout' => $layout])
        @endforeach
    @endif

@endsection