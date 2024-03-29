@extends('layouts.default', ['hide_marquee' => true])
@php $page = \App\Models\Page::firstWhere("template", "404-page") @endphp
@php $film = $page->content->random() @endphp

@section('title', $page->name)
@section('content')

    <div class="h-screen flex flex-col">
        <div class="flex-grow text-white bg-black flex-col flex items-center justify-center relative">
            {{ $film->getMedia('image')->first()->img()->attributes(['class' => 'opacity-50 inset-0 absolute object-cover w-full h-full']) }}
            <h1 class="type-xs-mono text-yellow mb-4 relative">{{ $page->name }}</h1>
            <p class="type-medium lg:type-large max-w-md text-center relative">{{ $film->message ?? $page->introduction }}
            </p>
        </div>
        <div class="bg-yellow py-8">
            <div class="container grid lg:grid-cols-4 gap-2">
                <div></div>
                <div class="col-span-1">
                    <h1 class="type-small">
                        <x-certificate :certificate="$film->certificate" :dark="true" />
                        {{ $film->title }}
                        <span class="type-xs-mono !font-normal">({{ $film->year }})</span>
                    </h1>

                </div>
                <div class="type-xs-mono col-span-2 max-w-lg hidden lg:block !normal-case">{{ $film->description }}</div>
            </div>
        </div>
    </div>
    <div class="type-xs-mono bg-yellow pb-8 block lg:hidden !normal-case">
        <div class="container">{{ $film->description }}
        </div>
    </div>
@endsection
