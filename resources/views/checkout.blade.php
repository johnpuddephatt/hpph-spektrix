@extends('layouts.default')
@section('title', 'Checkout')

@section('content')
    <div class="container my-24 min-h-screen max-w-5xl">
        <iframe
            src="https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/secure/checkout.aspx?resize=true"
            class="min-h-screen w-full" id="SpektrixIFrame" name="SpektrixIFrame"></iframe>
    </div>
@endsection
