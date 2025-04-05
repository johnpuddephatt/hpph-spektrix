@extends('layouts.default', ['header_class' => 'text-black'])
@section('title', 'Checkout test')

@section('content')
    <div class="container my-24 min-h-screen max-w-5xl">
        <iframe
            src="https://system.spektrix.com/{{$settings['spektrix_client_name']}}/website/secure/checkout/v2/payment?previewSpektrixPayments=true&resize=true&stylesheet=hpph-spektrix-2.css"
            class="min-h-screen w-full" id="SpektrixIFrame" name="SpektrixIFrame"></iframe>
    </div>
@endsection
