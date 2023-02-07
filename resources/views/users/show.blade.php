@extends('layouts.default', ['header_position' => 'absolute', 'edit_link' => route('nova.pages.edit', ['resource' => 'users', 'resourceId' => $user->id])])
@section('title', $user->name)
@section('content')
    <div class="fixed inset-0 -z-10 h-[75vh] w-full overflow-hidden bg-black">
        @if ($user->avatar)
            <img src="{{ $user->avatar }}" class="absolute top-0 right-0 bottom-0 h-full w-1/2 object-cover" />
        @endif
        <div class="fade-to-right pointer-events-none absolute left-1/2 top-0 bottom-0 w-72">
        </div>

        <div
            class="absolute left-1/2 top-1/2 w-1/2 max-w-xl -translate-x-1/2 -translate-y-1/2 transform text-center text-white">
            <h2 class="type-large">{{ $user->name }}</h2>
            <p class="type-xs-mono mt-4">{{ $user->role_title }}</p>
        </div>
    </div>

    <div class="relative z-[-1] mt-[75vh]">
        <div class="absolute bottom-full left-0 right-0 z-[1] mt-auto" id="event-content">
            <div class="px-4 pt-48 pb-12 text-white 2xl:px-6">
            </div>
        </div>

        <a href="#event-content"
            class="fixed left-1/2 top-[75vh] z-10 -translate-x-1/2 transform text-5xl text-white">@svg('chevron-down', 'h-16 w-16')</a>

    </div>

    <div class="bg-yellow">
        <div class="type-h4 container max-w-6xl py-16 text-center">{{ $user->role_description }}</div>
    </div>

    <x-users-grid :users="$users" />

@endsection
