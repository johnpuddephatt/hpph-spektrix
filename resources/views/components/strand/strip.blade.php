@props(['strand'])

@if ($strand)
    <a href="{{ $strand->url }}" {{ $attributes->class('flex flex-row px-4 type-xs-mono whitespace-nowrap  py-4 ') }}
        style="background-color: {{ $strand->color }}">
        <div>Part of <span class="font-bold font-sans">{{ $strand->name }}</span></div>
        @svg('arrow-right', 'inline-block ml-auto w-4 h-4')
    </a>
@endif
