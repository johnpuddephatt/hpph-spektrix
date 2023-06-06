@props(['strand', 'partof' => false, 'dark' => false])

@if ($strand)
    <div {{ $attributes->class('block text-center uppercase font-bold text-xs text-black whitespace-nowrap rounded py-0.5 px-2') }}
        style="@if ($dark) color:  {{ $strand->color }};  border-width: 1px; border-color:  {{ $strand->color }}; @else background-color: {{ $strand->color }} @endif">
        @if ($partof)
            <span class="lg:hidden font-normal">Part of</span>
        @endif
        {{ $strand->name }}
    </div>
@endif
