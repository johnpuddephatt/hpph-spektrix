@php
$width = isset($_tunes) ? ($_tunes->blockWidthTune ?: 'normal') : 'normal';
@endphp

<div class="@if ($block_width !== 'full') container max-w-6xl @endif relative my-16">
    <div class="@if ($block_width == 'normal') max-w-2xl @endif relative"
        style="padding-top: {{ ($height / $width) * 100 }}%">
        <iframe width="{{ $width }}px" height="{{ $height }}px" frameborder="0"
            class="@if ($width !== 'full') rounded-md @endif absolute inset-0 h-full w-full" allowfullscreen=""
            src="{{ $embed }}"></iframe>

        <div class="caption">
            {{ $caption }}
        </div>
    </div>
</div>
