@props(['season'])

@if ($season)
    <a href="{{ $season->url }}"
        {{ $attributes->class('flex flex-row px-4 type-xs-mono whitespace-nowrap  py-4 bg-black text-yellow') }}>
        <div>Part of <span class="font-bold font-sans">{{ $season->name }}</span></div>
        @svg('arrow-right', 'inline-block ml-auto w-4 h-4')
    </a>
@endif
