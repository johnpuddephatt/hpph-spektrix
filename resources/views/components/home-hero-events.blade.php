<div id="slider-wrapper" x-data="{ activeSlide: 0 }">
    @foreach ($events as $event)
        <div x-transition:enter="opacity-0" x-transition:leave="delay-500 opacity-0"
            x-show="{{ $loop->index }} == activeSlide" href="{{ $event->url }}" class="inset-0 absolute duration-500">
            @if ($event->video_thumbnail)
                {!! $event->video_thumbnail !!}

                @if ($event->video_conversions)
                    <div class="absolute inset-0 -z-10 h-full w-full bg-black opacity-0">
                        <video
                            onplay="(function(e){e.parentNode.classList.remove('opacity-0');e.parentNode.classList.add('opacity-100') })(this)"
                            class="absolute inset-0 -z-10 h-full w-full object-cover opacity-80" playsinline muted
                            autoplay loop>
                            @foreach ($event->video_conversions->{'1280x720'} as $format => $url)
                                <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                            @endforeach
                        </video>
                    </div>
                @endif
            @elseif ($event->src)
                <x-image :src="$event->src" :srcset="$event->srcset"
                    class="opacity-80 absolute inset-0 h-full w-full object-cover object-center lg:-z-10" />
            @endif

            <div class="transform text-white h-screen lg:h-auto justify-center lg:justify-start flex flex-col text-center lg:text-left items-center lg:items-start lg:flex-row gap-8 lg:gap-12 container absolute bottom-1/2 translate-y-1/2 lg:translate-y-0 lg:bottom-8 z-50"
                :class="scrolled ? '' :
                    'pointer-events-none opacity-0 lg:pointer-events-auto translate-y-8 lg:opacity-100 lg:translate-y-0'">
                <div class="type-xs-mono mt-0 lg:mt-auto w-16">
                    <div class="flex flex-row absolute top-1/2 left-0 right-0 lg:static">
                        <button class="absolute left-8 lg:static" aria-label="Previous event"
                            x-on:click.prevent="activeSlide = (activeSlide > 0) ? ( activeSlide - 1) : {{ $loop->count - 1 }} ">
                            @svg('chevron-right', 'rotate-180 -ml-2 w-10 h-10')
                        </button>
                        <button class="absolute right-8 lg:static" aria-label="Next event"
                            x-on:click.prevent="activeSlide = (activeSlide < {{ $loop->count - 1 }}) ?  (activeSlide + 1) : 0">
                            @svg('chevron-right', 'w-10 h-10 -ml-2')</button>
                    </div>
                    <div class="mt-4">{{ $event->status }}</div>
                </div>
                <div class="">

                    <x-strand-badge :strand="$event->strand" :partof="true"
                        class="absolute left-1/2 -translate-x-1/2 lg:transform-none bottom-8 lg:static mb-4 inline-block" />

                    <h3 class="type-medium md:type-regular">{{ $event->name }}
                        <x-certificate :certificate="$event->certificate_age_guidance" :dark="true" />
                    </h3>

                    <div class="mt-8 mx-auto lg:mt-1">
                        <button class="type-small inline-block py-0 bg-yellow text-black rounded-full px-2"
                            @click="$dispatch('booking', { eventID: '{{ $event->id }}', event: '{{ $event->name }}', certificate: '{{ $event->certificate_age_guidance }}' })">Book</button>
                        /
                        <a class="type-small inline-block py-0 bg-gray-dark text-white rounded-full px-2"
                            href="{{ $event->url }}">Info</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
