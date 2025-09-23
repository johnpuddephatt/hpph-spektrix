@extends('layouts.app')

@section('templatecontent')
    <div class="flex h-screen items-center justify-center bg-black text-white">
        <div class="max-w-lg px-4 text-center">
            @svg('logo-full', 'w-48 block mx-auto text-yellow')</a>

            <div class="w-full overflow-hidden">

                <div class="prose py-16">{{ $settings['alert_message'] }}</span>

                </div>
                @if ($settings['alert_url'])
                    <a class="underline" target="_blank" href="{{ $settings['alert_url'] }}">Further information</a>
                @endif
            </div>
        </div>
    @endsection
