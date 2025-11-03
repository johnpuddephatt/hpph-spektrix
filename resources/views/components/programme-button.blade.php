@props(['type', 'selected'])

<button
    {{ $attributes->class(($selected == $type ? 'bg-yellow ' : ' text-black hover:bg-black-light bg-sand hover:bg-sand-dark ') . 'type-xs-mono rounded px-3 py-1.5') }}
    wire:click="$set('type', '{{ $type }}');">
    {{ $slot }}</button>
