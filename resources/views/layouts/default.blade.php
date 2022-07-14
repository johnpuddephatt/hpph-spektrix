@extends('layouts.app')

@include('components.navigation', [
    'header_colour' => $header_colour ?? 'default',
    'header_position' => $header_position ?? 'default',
])

@section('content')
    @yield('content')
@endsection
