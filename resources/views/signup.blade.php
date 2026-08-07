@extends('layouts.default', ['header_class' => 'text-black'])

@section('content')
    <div class="bg-sand container pt-36 pb-6 flex flex-row items-end justify-between">

        <h1 class="type-medium lg:type-large">
            Signup</h1>

    </div>
    <div class="container pt-[4.5rem]">
        <livewire:signup-form :form="$form" />
    </div>
@endsection
