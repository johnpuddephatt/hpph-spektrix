@extends('layouts.app')

@section('templatecontent')
    @include('components.navigation', [
        'header_colour' => $header_colour ?? 'default',
        'header_position' => $header_position ?? 'default',
    ])

    <div class="relative">
        @yield('content')</div>
@endsection
