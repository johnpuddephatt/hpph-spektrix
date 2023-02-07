@php
$width = isset($_tunes) ? ($_tunes->blockWidthTune ?: 'normal') : 'normal';
@endphp

<div
    class="@if (($_align ?? false == 'right') && $width !== 'full') lg:w-1/2 lg:ml-[50%] mx-0 @endif @if ($width === 'full') max-w-7xl @elseif($width === 'wide') max-w-none @else max-w-6xl @endif container my-16">
    <blockquote
        class="@if ($width == 'normal') max-w-2xl @endif @if ($width == 'wide') max-w-4xl @endif @if ($width == 'full') max-w-6xl @endif relative">
        <p class="type-medium mb-8"><span class="right-full text-yellow xl:absolute xl:pr-4">“</span>{{ $text }}
        </p>
        <cite class="block not-italic">{!! $caption !!}</cite>
    </blockquote>
</div>
