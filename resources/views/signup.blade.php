@extends('layouts.default', ['header_class' => 'text-black'])

@section('content')
    <div class="bg-sand container pt-36 pb-6 flex flex-row items-end justify-between">

        <h1 class="type-medium lg:type-large">
            Signup</h1>

    </div>
    <div class="container pt-[4.5rem]">

        <form method="POST" action="{{ route('signup.submit') }}" class="mt-8">
            @csrf
            @if (session('success'))
                <div class="bg-yellow border px-4 py-3 rounded relative my-8 max-w-lg" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <label for="firstName" class="block">First name
                <input type="text" name="firstName" id="firstName" class="max-w-full block border p-4 w-64 mt-2">
            </label>
            <label for="lastName" class="block mt-4">Last name
                <input type="text" name="lastName" id="lastName" class="border p-4 w-64 max-w-full block mt-2">
            </label>
            <label for="email" class="block mt-4">Email
                <input type="email" name="email" id="email" class="border p-4 w-64 max-w-full block mt-2">
            </label>

            <h3 class="type-medium mt-12 mb-4">Contact preferences</h3>
            @foreach ($contact_preferences as $contact_preference)
                <label for="contact_preference_{{ $contact_preference['id'] }}" class="block">
                    <input type="checkbox" name="AgreedStatements[{{ $contact_preference['id'] }}]"
                        id="contact_preference_{{ $contact_preference['id'] }}" value="{{ $contact_preference['id'] }}"
                        class="mr-2">
                    {{ $contact_preference['text'] }}
            @endforeach

            <hr>
            <h3 class="type-medium mt-12 mb-4">Tags</h3>
            @foreach ($tags as $taggroup)
                <h2 class="type-small mt-8 mb-4">{{ $taggroup['name'] }}</h2>
                <p>{{ $taggroup['description'] }}</p>
                @foreach ($taggroup['tags'] as $tag)
                    <label for="contact_preference_{{ $tag['id'] }}" class="block">
                        <input type="checkbox" name="Tags[{{ $tag['id'] }}]"
                            id="contact_preference_{{ $tag['id'] }}" value="{{ $tag['id'] }}" class="mr-2">
                        {{ $tag['name'] }}
                @endforeach
            @endforeach

            <button type="submit" class="bg-black text-white p-4 mt-8">Submit</button>

        </form>
    </div>
@endsection
