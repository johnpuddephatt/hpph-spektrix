@props(['strand'])

@if ($strand)
    <div {{ $attributes->class('block text-center uppercase font-bold text-xs whitespace-nowrap rounded border border-current py-0.5 px-2') }}
        style="color: {{ $strand->color }}">
        {{ $strand->name }}
    </div>
@endif
