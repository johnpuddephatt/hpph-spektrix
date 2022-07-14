<button
    class="{{ $selected == $type ? 'bg-yellow border-yellow' : 'border-gray-light' }} type-annotation rounded border p-1"
    wire:click="$set('type', '{{ $type }}')">
    <span
        class="{{ $selected == $type ? 'bg-black' : 'bg-gray-light' }} mr-1 inline-block h-2.5 w-2.5 rounded-full align-baseline"></span>{{ $slot }}</button>
