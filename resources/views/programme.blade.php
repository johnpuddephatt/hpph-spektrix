@extends('layouts.default')
@section('title', 'What’s on')

@section('content')
    <div class="px-4 2xl:px-6">
        <div class="mt-24 mb-8 flex flex-row items-end justify-between">
            <h1 class="type-h1">What’s on</h1>

            <!--<a class="flex flex-row items-center rounded bg-gray px-8 py-3 font-bold" href="#">Download latest film
                    guide (@todo) <span class="type-label ml-4 inline-block font-normal">[PDF]</span>
                    @svg('down-chevron', 'w-5 h-5 ml-2')
                </a>-->
        </div>

        <livewire:programme />
    </div>
@endsection
