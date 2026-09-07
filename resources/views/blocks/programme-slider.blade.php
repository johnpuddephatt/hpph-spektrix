{{--
    The what's on slider for a strand or season: every future screening (or
    whole event, when the page's Display type is set to Events) attached to it.

    $layout->entries is resolved by the layout from the page it sits on, so the
    block can be moved anywhere in the page order. It renders nothing when
    there is nothing on.

    The slide width follows the number of entries — one or two entries get
    wider cards rather than a half-empty row.
--}}

@php($entries = $layout->entries)

@if ($entries->count())
    {{-- Seasons title this section in yellow, strands in their own colour and
         white when they have none. The pretitle stays white in both. --}}
    <div @class([
        'bg-black',
        'text-yellow' => $layout->subject_type === 'season',
        'text-white' => $layout->subject_type !== 'season',
    ])>
        <div class="container pb-16 pt-24">
            <p class="type-xs-mono container mb-2 text-center text-white">{{ $layout->pretitle_text }}</p>
            <h2 @if ($layout->accent_color) style="color: {{ $layout->accent_color }}" @endif
                class="type-regular lg:type-medium container mb-12 text-center">
                {{ $layout->title_text }}
            </h2>

            <x-instance-slider :type="$layout->subject->display_type" :entries="$entries" :layout="match ($entries->count()) {
                1 => 'extra-wide',
                2 => 'wide',
                default => 'default',
            }" :color="$layout->slider_color"
                :show_strand="false" />
        </div>
    </div>
@endif
