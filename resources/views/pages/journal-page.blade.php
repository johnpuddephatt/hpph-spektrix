@extends('layouts.default', ['header_class' => 'text-white lg:text-black', 'logo_background' => 'text-black'])
@section('title', 'Journal')
@section('content')
    <x-journal-indexheadercard class="" :post="$page->featured_post" />
    <livewire:posts-index :featured_post="$page->featured_post->id" />
@endsection
