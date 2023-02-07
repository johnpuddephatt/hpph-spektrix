@extends('layouts.app')

@section('templatecontent')
    @include('spektrix-components.booking-path')

    @include('components.menu-button')

    @include('sections.header', [
        'header_colour' => $header_colour ?? 'default',
        'header_position' => $header_position ?? 'static',
    ])

    <main class="relative">
        @yield('content')
    </main>

    @include('sections.footer')
@endsection
