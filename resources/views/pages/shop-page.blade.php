@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.index', ['resource' => 'products'])])
@section('title', 'Shop')
@section('content')
    <livewire:shop />
@endsection
