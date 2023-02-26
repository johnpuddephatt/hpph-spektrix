@props(['instance', 'show_strand' => true, 'layout' => 'default', 'color' => null, 'dark' => true])
{{-- Layout: home, default, wide, extra-wide --}}

<div
    {{ $attributes->class(['swiper-slide', 'relative', 'text-white', 'text-center' => $layout == 'home', 'pt-8 pb-16 md:py-0 grid md:grid-cols-2' => $layout == 'extra-wide', 'py-8 lg:gap-4 grid lg:grid-cols-2' => $layout == 'wide']) }}>

    <div
        class="{{ $layout == 'home' ? 'flex-col-reverse' : 'flex-row' }} @if ($layout == 'extra-wide') gap-2 mb-3 lg:mb-0 flex md:hidden @elseif($layout == 'wide') gap-2 mb-3 lg:mb-0 flex lg:hidden  @else gap-1 mb-6 flex @endif">
        <div class="{{ $layout == 'home' ? 'type-regular' : 'type-xs-mono' }} text-yellow"
            @if ($color) style="color: {{ $color }}" @endif>
            {{ $instance->start_time }}</div>
        <div class="type-xs-mono">{{ $instance->start_date }}</div>
    </div>

    <div class="@if ($layout == 'extra-wide') md:px-8 md:my-16 @endif md:justify-self-center lg:max-w-lg w-full">
        <div class="relative aspect-video flex flex-col">
            <div class="w-full relative flex-1 bg-gray rounded overflow-hidden">
                <x-image width="100%" class="absolute max-w-none inset-0" :src="$instance->src ?? $instance->event->featuredImage->getUrl('wide')" :srcset="$instance->srcset ?? $instance->event->featuredImage->getSrcset('wide')" />
            </div>
            <x-accessibilities class="absolute top-2 right-1.5" :dark="true" :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl"
                :audiodescribed="$instance->audio_described" :specialevent="$instance->special_event" />
            @if ($show_strand)
                <x-strand-badge :dark="$dark" class="mt-2" :strand="$instance->strand" />
            @endif
        </div>
    </div>

    <div class="@if ($layout == 'extra-wide') md:px-8 md:py-16 md:border-l md:border-gray-dark @endif">
        <div class="@if ($layout == 'wide' || $layout == 'extra-wide') flex flex-col justify-between max-w-lg md:mx-auto @endif h-full">

            <div
                class="@if ($layout == 'extra-wide') md:flex @elseif($layout == 'wide') lg:flex @endif mt-3 hidden gap-2">
                <div class="type-xs-mono text-yellow"
                    @if ($color) style="color: {{ $color }}" @endif>
                    {{ $instance->start_time }}</div>
                <div class="{{ $layout == 'home' ? 'type-regular' : 'type-xs-mono' }}">
                    {{ $instance->start_date }}
                </div>
            </div>

            <div>
                <div @if ($layout == 'home' || $layout == 'default') class="mb-2 h-[4.5rem] mt-6" @else class="mb-4 mt-6 @if ($layout == 'extra-wide') md:mt-0 @elseif($layout == 'wide') lg:mt-0 @endif"
                    @endif>
                    <h3 class="type-regular inline-block">{{ $instance->event->name }}
                        <x-certificate :dark="true" :certificate="$instance->event->certificate_age_guidance" />
                    </h3>
                </div>

                <div>

                    <button class="type-small relative z-10 inline-block py-0 bg-yellow text-black rounded-full px-2"
                        @if ($color) style="background-color: {{ $color }}" @endif
                        @click="$dispatch('booking', { eventID: '{{ $instance->event->id }}', instanceID: '{{ filter_var($instance->id, FILTER_SANITIZE_NUMBER_INT) }}', event: '{{ $instance->event->name }}', certificate: '{{ $instance->event->certificate_age_guidance }}' })">Book</button>
                    /
                    <a class="type-small before:absolute before:inset-0 inline-block py-0 bg-gray-dark text-white rounded-full px-2"
                        href="{{ $instance->url }}">Info</a>
                </div>
            </div>
        </div>
    </div>
</div>
