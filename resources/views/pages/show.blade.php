@extends('layouts.default', ['header_colour' => $page->header_type, 'header_position' => $page->header_position, 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page->id])]) @section('content')

@section('content')
    @foreach ($page->content as $block)
        @includeIf('blocks.' . $block->name(), $block->fields())
    @endforeach
@endsection
