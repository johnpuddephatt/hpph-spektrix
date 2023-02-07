@extends('layouts.default', ['header_position' => 'relative', 'header_background' => 'bg-sand', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    @include('sections.pageheader-default')

    <x-users-grid :users="$page->content->users" />
@endsection
