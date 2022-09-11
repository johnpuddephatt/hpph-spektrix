@extends('layouts.default', ['header_background' => null, 'header_position' => 'fixed', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    asdfasdf
@endsection
