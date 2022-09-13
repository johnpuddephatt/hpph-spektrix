@extends('layouts.app')

@section('templatecontent')
    <div x-data="{ open: false }">
        <button @click="open = !open; $dispatch('navtoggled', open)" aria-label="Toggle menu"
            class="fixed top-3 right-3 z-50 h-10 w-10 rounded-full bg-yellow-dark lg:hidden">
            @svg('menu', 'h-10 w-10 text-black')
        </button>
    </div>

    @include('sections.header', [
        'header_colour' => $header_colour ?? 'default',
        'header_position' => $header_position ?? 'default',
    ])

    <main class="relative">
        @yield('content')
    </main>

    @include('sections.footer')
@endsection
