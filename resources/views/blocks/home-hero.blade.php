<div class="mt-[100vh] block w-screen overflow-hidden">
</div>

<div class="fixed inset-0 -z-10 h-screen w-full overflow-hidden border-b-[1rem] border-yellow bg-black">

    <div id="slider-wrapper" x-data="{ activeSlide: 0 }">
        @foreach ($layout->events as $event)
            <div x-transition:enter="opacity-0" x-transition:leave="delay-500 opacity-0"
                x-show="{{ $loop->index }} == activeSlide" href="{{ $event->url }}"
                class="inset-0 absolute duration-500">
                @if ($event->featuredVideo)
                    {!! $event->featuredVideo->img('thumb', [
                        'id' => $event->id,
                        'class' => '-z-10 w-full absolute opacity-70 h-full inset-0 object-cover',
                    ]) !!}

                    @if ($event->featuredVideo->video_conversions)
                        @php($conversions = json_decode($event->featuredVideo->video_conversions))
                        <div class="absolute inset-0 -z-10 h-full w-full bg-black opacity-0">
                            <video
                                onplay="(function(e){e.parentNode.classList.remove('opacity-0');e.parentNode.classList.add('opacity-100') })(this)"
                                class="absolute inset-0 -z-10 h-full w-full object-cover opacity-70" playsinline muted
                                autoplay loop>
                                @foreach ($conversions->{'1280x720'} as $format => $url)
                                    <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                                @endforeach
                            </video>
                        </div>
                    @endif
                @else
                    {!! $event->featuredImage->img('wide')->attributes(['class' => 'opacity-70 absolute inset-0 h-full w-full object-cover object-center lg:-z-10']) !!}
                @endif

                <div class="transform text-white h-screen lg:h-auto justify-center lg:justify-start flex flex-col text-center lg:text-left items-center lg:items-end lg:flex-row gap-8 lg:gap-12 container absolute bottom-1/2 translate-y-1/2 lg:translate-y-0 lg:bottom-8 z-50"
                    :class="scrolled ? '' :
                        'pointer-events-none opacity-0 lg:pointer-events-auto translate-y-8 lg:opacity-100 lg:translate-y-0'">
                    <div class="type-xs-mono mt-0 lg:mt-auto w-16">
                        @if ($layout->events->count() > 1)
                            <div class="flex flex-row absolute top-1/2 left-0 right-0 lg:static">
                                <button class="absolute left-2 lg:static" aria-label="Previous event"
                                    x-on:click.prevent="activeSlide = (activeSlide > 0) ? ( activeSlide - 1) : {{ $loop->count - 1 }} ">
                                    @svg('chevron-right', 'rotate-180 -ml-2 w-12 h-12')
                                </button>
                                <button class="absolute right-2 lg:static" aria-label="Next event"
                                    x-on:click.prevent="activeSlide = (activeSlide < {{ $loop->count - 1 }}) ?  (activeSlide + 1) : 0">
                                    @svg('chevron-right', 'w-12 h-12 -ml-3')</button>
                            </div>
                        @endif
                        <div class="h-12 mt-auto">{{ $event->date_range }}</div>
                    </div>
                    <div class="">

                        <x-strand.badge :strand="$event->strand" :partof="true"
                            class="absolute left-1/2 -translate-x-1/2 lg:transform-none bottom-8 lg:static mb-4 inline-block" />

                        <h3 class="type-medium md:type-regular px-8 lg:px-0"><a
                                href="{{ $event->url }}">{{ $event->name }}
                                <x-certificate :certificate="$event->certificate_age_guidance" :dark="true" />
                            </a>
                        </h3>

                        <div class="-mb-1 mt-8 mx-auto lg:mt-1">
                            <a class="type-small inline-block py-0 bg-gray-dark text-white rounded-full px-2"
                                href="{{ $event->url }}">Info</a> / <button
                                class="type-small inline-block py-0 bg-yellow text-black rounded-full px-2"
                                @click="$dispatch('booking', { eventID: '{{ $event->id }}', event: '{{ $event->name }}', certificate: '{{ $event->certificate_age_guidance }}' })">Book</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div :class="scrolled ? 'opacity-0 -translate-y-8 lg:opacity-100 lg:translate-y-0' : ''"
        class="absolute inset-0 transform transition">
        @svg('logo-full', 'h-auto max-w-[80vw]  lg:px-0 w-72 lg:w-96 absolute top-[50vh] left-1/2 -translate-x-1/2 -translate-y-1/2 transform text-yellow')
        <button @click="document.documentElement.scrollTop = 12"
            class="fixed left-1/2 bottom-16 z-20 -translate-x-1/2 transform rounded-full bg-black p-4 text-5xl text-white lg:hidden">@svg('arrow-right', 'transform rotate-90 h-6 w-6')</button>
    </div>
</div>
