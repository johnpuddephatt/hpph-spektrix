{{--
    The coloured band under a strand or season hero.

    The name and description come from the strand or season itself, since the
    cards and menus elsewhere on the site read the same fields. The additional
    description and funders logo belong to the block, because this is the only
    place they are ever shown.

    The band takes the page's accent where there is one — most strands have no
    colour set, and seasons have none at all, in which case it stays the
    default yellow. Either way it is the one light section on the page, sitting
    between the black hero and the black blocks below.
--}}

@php($subject = $layout->subject)

<div class="bg-yellow pb-24 pt-8 text-center lg:pb-16 lg:pt-12"
    @if ($layout->accent_color) style="background-color: {{ $layout->accent_color }}" @endif>
    <div class="type-xs-mono pb-12 lg:pb-8">{{ $subject->name }}</div>
    <div class="type-regular lg:type-medium container max-w-4xl text-center">{{ $subject->description }}</div>
    @if ($layout->additional_description)
        <div class="prose container mt-6 max-w-3xl text-center">{!! $layout->additional_description !!}</div>
    @endif
    @if ($layout->funders_logo)
        @if ($layout->subject_type === 'season')
            {{-- Logos are artworked at twice their intended size, so halve the
                 natural width before capping it. Strands predate this and are
                 left as they were. --}}
            <img onload="this.style.width = this.clientWidth/2 + 'px'; this.classList.add('max-w-sm'); this.classList.remove('opacity-0')"
                src="{{ Storage::url($layout->funders_logo) }}" alt=""
                class="mx-auto mt-8 h-auto w-auto px-4 opacity-0">
        @else
            <img src="{{ Storage::url($layout->funders_logo) }}" alt=""
                class="mx-auto mt-6 h-auto w-auto max-w-sm px-4">
        @endif
    @endif
</div>
