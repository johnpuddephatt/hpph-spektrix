@extends('layouts.app')

@section('templatecontent')
    @include('spektrix-components.booking-path')

    @include('sections.header')

    <main class="relative">
        @yield('content')
    </main>

    @include('sections.footer')
@endsection
