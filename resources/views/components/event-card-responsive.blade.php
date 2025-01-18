@props(['event', 'show_strand' => true, 'layout' => 'default', 'color' => null, 'dark' => true])
{{-- Layout: home, default, wide, extra-wide --}}

<div
    {{ $attributes->class(['group', 'swiper-slide', 'relative', 'text-white', 'text-center' => $layout == 'home', 'pt-8 pb-16 md:py-0 !grid md:grid-cols-2' => $layout == 'extra-wide', 'py-8 lg:gap-4 !grid lg:grid-cols-2' => $layout == 'wide']) }}>
    <div
        class="{{ $layout == 'home' ? 'flex-col-reverse' : 'flex-row' }} @if ($layout == 'extra-wide') gap-2 mb-3 lg:mb-0 flex md:hidden @elseif($layout == 'wide') gap-2 mb-3 lg:mb-0 flex lg:hidden  @else gap-1 mb-6 flex @endif">
        <div class="{{ $layout == 'home' ? 'type-regular' : 'type-xs-mono' }} @if (!$color) group-hover:text-yellow @endif text-white"
            @if ($color) style="color: {{ $color }}" @endif>
            {{ $event->coming_soon ? 'Coming soon • ' : '' }}</div>
        <div class="type-xs-mono">
            {!! $event->coming_soon ?? $event->date_range !!}</div>
    </div>

    <div class="@if ($layout == 'extra-wide') md:px-8 md:my-16 lg:max-w-lg @endif md:justify-self-center w-full">
        <div class="relative aspect-video flex flex-col">
            <div class="w-full relative bg-black-light flex-1 rounded overflow-hidden">
                @if ($event->featuredImage)
                    {!! $event->featuredImage->img('wide')->attributes([ 
                        'loading' => 'lazy',
                        'class' => 'group-hover:scale-105 transition duration-500 block w-full absolute max-w-none inset-0',
                    ]) !!}
                @endif
            </div>


             <x-accessibilities class="absolute top-2 right-1.5" :audiodescribed="$event->audio_description" />
            @if ($show_strand && $event->strand?->show_on_event_card)
                <x-strand.badge  :dark="$dark" class="mt-2"
                    :strand="$event->strand" />
            @endif

       
        </div>
    </div>

    <div class="@if ($layout == 'extra-wide') md:px-8 md:py-16 md:border-l md:border-gray-dark @endif">
        <div class="@if ($layout == 'wide' || $layout == 'extra-wide') flex flex-col justify-between max-w-lg md:mx-auto @endif h-full">

            <div
                class="@if ($layout == 'extra-wide') md:flex @elseif($layout == 'wide') lg:flex @endif mt-3 hidden gap-2">
                <div class="type-xs-mono text-yellow"
                    @if ($color) style="color: {{ $color }}" @endif>
                    {{ $event->coming_soon ? 'Coming soon • ' : '' }}</div>
                <div class="{{ $layout == 'home' ? 'type-regular' : 'type-xs-mono' }}">
                    {!! $event->coming_soon ?? $event->date_range !!}
                </div>
            </div>

            <div>
                <div @if ($layout == 'home' || $layout == 'default') class="mb-2 min-h-[4.5rem] mt-6" @else class="mb-4 mt-6 @if ($layout == 'extra-wide') md:mt-0 @elseif($layout == 'wide') lg:mt-0 @endif"
                    @endif>
                    <h3 class="type-regular">{{ $event->name }}
                        <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
                    </h3>
                    @if ($event->subtitle)
                        <p class="pt-1 leading-none">{{ $event->subtitle }}</p>
                    @endif

                
                </div>

                <div>
                    <a class="type-small hover:text-gray-dark border-gray-dark hover:bg-white border before:absolute before:inset-0 inline-block py-0 bg-gray-dark text-white rounded-full px-2"
                        href="{{ $event->url }}">Info</a>
                    @if (!$event->coming_soon) / 
                            <button
                                class="type-small border border-yellow hover:!bg-black hover:text-current relative z-[1] inline-block py-0 bg-yellow text-black rounded-full px-2"
                                @if ($color) style="background-color: {{ $color }}; border-color: {{ $color }}" @endif
                                @click="$event.stopPropagation(), $dispatch('booking', { eventID: '{{ $event->id }}', event: '{{ htmlentities($event->name, ENT_QUOTES) }}', certificate: '{{ htmlentities($event->certificate_age_guidance, ENT_QUOTES) }}' })">Book</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
