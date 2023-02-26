@extends('layouts.default', ['header_position' => 'fixed', 'header_class' => 'text-white lg:text-black', 'header_background' => 'bg-sand', 'logo_background' => 'text-black'])
@section('title', 'Journal')
@section('content')
    <x-journal-indexheadercard class="" :post="$page->content->featured_post" />
    <livewire:posts-index :featured_post="$page->content->featured_post->id" />
@endsection
