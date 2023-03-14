@extends('layouts.default', ['logo_background' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    @if ($page->content)
        @foreach ($page->content as $layout)
            @include('blocks.' . $layout->name(), ['layout' => $layout])
        @endforeach
    @endif
@endsection
