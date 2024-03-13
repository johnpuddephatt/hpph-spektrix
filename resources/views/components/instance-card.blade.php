@props(['instance', 'show_strand' => true, 'layout' => 'default', 'color' => null, 'dark' => true])
{{-- Layout: home, default, wide, extra-wide --}}

<div
    {{ $attributes->class(['group', 'swiper-slide', 'relative', 'text-white', 'text-center' => $layout == 'home', 'pt-8 pb-16 md:py-0 grid md:grid-cols-2' => $layout == 'extra-wide', 'py-8 lg:gap-4 grid lg:grid-cols-2' => $layout == 'wide']) }}>
    <div
        class="{{ $layout == 'home' ? 'flex-col-reverse' : 'flex-row' }} @if ($layout == 'extra-wide') gap-2 mb-3 lg:mb-0 flex md:hidden @elseif($layout == 'wide') gap-2 mb-3 lg:mb-0 flex lg:hidden  @else gap-1 mb-6 flex @endif">
        <div class="{{ $layout == 'home' ? 'type-regular' : 'type-xs-mono' }} @if (!$color) group-hover:text-yellow @endif text-white"
            @if ($color) style="color: {{ $color }}" @endif>
            {{ $instance->start_time }}</div>
        <div class="type-xs-mono">{{ $instance->start_date }}</div>
    </div>

    <div class="@if ($layout == 'extra-wide') md:px-8 md:my-16 lg:max-w-lg @endif md:justify-self-center w-full">
        <div class="relative aspect-video flex flex-col">
            <div class="w-full relative flex-1 rounded overflow-hidden">
                {!! $instance->event->featuredImage->img('wide')->attributes([
                    'loading' => 'lazy',
                    'class' => 'group-hover:scale-105 transition duration-500 block w-full absolute max-w-none inset-0',
                ]) !!}
            </div>

            <x-accessibilities class="absolute top-2 right-1.5" :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->event->audio_description"
                :relaxed="$instance->relaxed" />
            @if ($show_strand && $instance->strand?->show_on_instance_card)
                <x-strand.badge :dark="$dark" class="mt-2" :strand="$instance->strand" />
            @endif
        </div>
    </div>

    <div class="@if ($layout == 'extra-wide') md:px-8 md:py-16 md:border-l md:border-gray-dark @endif">
        <div class="@if ($layout == 'wide' || $layout == 'extra-wide') flex flex-col justify-between max-w-lg md:mx-auto @endif h-full">

            <div
                class="@if ($layout == 'extra-wide') md:flex @elseif($layout == 'wide') lg:flex @endif mt-3 hidden gap-2">
                <div class="type-xs-mono text-yellow"
                    @if ($color) style="color: {{ $color }}" @endif>
                    {{ $instance->event->coming_soon ? 'Coming soon • ' : $instance->start_time }}</div>
                <div class="{{ $layout == 'home' ? 'type-regular' : 'type-xs-mono' }}">
                    {{ $instance->event->coming_soon ? $instance->event->coming_soon : $instance->start_date }}
                </div>
            </div>

            <div>
                <div @if ($layout == 'home' || $layout == 'default') class="mb-2 min-h-[4.5rem] mt-6" @else class="mb-4 mt-6 @if ($layout == 'extra-wide') md:mt-0 @elseif($layout == 'wide') lg:mt-0 @endif"
                    @endif>
                    <h3 class="type-regular">{{ $instance->event->name }}
                        <x-certificate :dark="true" :certificate="$instance->event->certificate_age_guidance" />
                    </h3>
                    @if ($instance->event->subtitle)
                        <p class="pt-1 leading-none">{{ $instance->event->subtitle }}</p>
                    @endif

                    @if ($instance->special_event || $instance->format)
                        <div class="mt-2">
                            <x-special-event-badge>{{ $instance->special_event }}</x-special-event-badge>
                            <x-special-event-badge class="">{{ $instance->format }}</x-special-event-badge>
                        </div>
                    @endif
                </div>

                <div>
                    <a class="type-small hover:text-gray-dark border-gray-dark hover:bg-white border before:absolute before:inset-0 inline-block py-0 bg-gray-dark text-white rounded-full px-2"
                        href="{{ $instance->url }}">Info</a>
                    @if (!$instance->event->coming_soon) / <button
                            class="type-small border border-yellow hover:!bg-black hover:text-current relative z-[1] inline-block py-0 bg-yellow text-black rounded-full px-2"
                            @if ($color) style="background-color: {{ $color }}; border-color: {{ $color }}" @endif
                            @click="$dispatch('booking', { eventID: '{{ $instance->event->id }}', instanceID: '{{ $instance->short_id }}', event: '{{ htmlentities($instance->event->name, ENT_QUOTES) }}', certificate: '{{ htmlentities($instance->event->certificate_age_guidance, ENT_QUOTES) }}' })">Book</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
