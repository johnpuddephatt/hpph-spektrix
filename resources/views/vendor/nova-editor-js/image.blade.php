@php
$width = isset($_tunes) ? ($_tunes->blockWidthTune ?: 'normal') : 'normal';
@endphp

{{ $width }}

<div class="@if ($width !== 'full') container max-w-6xl @endif relative my-16">
    <figure class="@if ($width == 'normal') max-w-2xl @endif">
        <img class="@if ($width !== 'full') rounded-md @endif w-full" src="{{ $file->url }}"
            alt="{{ $caption }}">
        @if (!empty($caption))
            <figcaption
                class="type-label @if ($width !== 'full') xl:transform xl:absolute xl:left-4 xl:max-w-xs xl:bottom-0 xl:-rotate-90 xl:origin-bottom-left @else container mx-auto max-w-6xl @endif mt-2">
                {{ $caption }}</figcaption>
        @endif
    </figure>
</div>
