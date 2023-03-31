@extends('layouts.default', ['header_class' => 'text-white lg:text-black', 'logo_background' => 'text-black', 'edit_link' => route('nova.pages.index', ['resource' => 'products'])])
@section('title', 'Shop')
@section('content')
    <livewire:shop />
@endsection
