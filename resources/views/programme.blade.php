@extends('layouts.default', ['header_position' => 'fixed', 'header_class' => 'text-black'])
@section('title', 'What’s on')

@section('content')
    <livewire:programme />
@endsection
