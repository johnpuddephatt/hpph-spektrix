@extends('layouts.default', ['header_position' => 'fixed', 'header_background' => 'bg-sand', 'header_class' => 'text-black'])
@section('title', 'Journal')
@section('content')
    <x-journal-indexheadercard class="" :post="$page->content->featured_post" />
    <livewire:posts-index :featured_post="$page->content->featured_post->id" />
@endsection
