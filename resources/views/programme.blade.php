@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="mt-24 mb-8 flex flex-row items-end justify-between">
            <h1 class="type-h1">What’s on</h1>

            <a class="flex flex-row items-center rounded bg-gray px-8 py-3 font-bold" href="#">Download latest film
                guide (@todo) <span class="type-label ml-4 inline-block font-normal">[PDF]</span> <span
                    class="align-center ml-2 inline-block h-6 w-6 rounded bg-gray-light"></span></a>
        </div>
    </div>
    <div class="container">
        <livewire:programme />
    </div>
@endsection
