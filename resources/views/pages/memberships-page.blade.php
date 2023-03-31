@push('webComponents', '#spektrix-memberships')
@extends('layouts.default', ['header_class' => 'text-white', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page->id])])

@section('title', $page->name)
@section('content')

    @include('sections.pageheader')

    @if ($page->content)
        @foreach ($page->content as $layout)
            @include('blocks.' . $layout->name(), ['layout' => $layout])
        @endforeach
    @endif
@endsection
