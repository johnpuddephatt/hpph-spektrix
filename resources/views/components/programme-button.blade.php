@props(['type', 'selected'])

<button
    {{ $attributes->class(($selected == $type ? 'bg-yellow ' : 'bg-black text-white lg:text-black hover:bg-black-light lg:bg-sand lg:hover:bg-sand-dark ') . 'type-xs-mono lg:rounded px-3 py-4 lg:py-1.5') }}
    wire:click="$set('type', '{{ $type }}');">
    {{ $slot }}</button>
