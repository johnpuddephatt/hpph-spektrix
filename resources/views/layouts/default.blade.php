@extends('layouts.app')

@section('templatecontent')
    @include('spektrix-components.booking-path')

    <x-alert />
    @include('sections.header')

    <main class="relative">
        @yield('content')
    </main>

    @include('sections.footer')
@endsection
