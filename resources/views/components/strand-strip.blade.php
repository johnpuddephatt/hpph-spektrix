@props(['strand'])

@if ($strand)
    <a href="{{ $strand->url }}" {{ $attributes->class('block px-6 type-xs-mono whitespace-nowrap  py-4 ') }}
        style="background-color: {{ $strand->color }}">
        Part of <span class="font-bold font-sans">{{ $strand->name }}</span>
    </a>
@endif
