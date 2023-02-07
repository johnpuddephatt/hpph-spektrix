    <div id="slider-wrapper" x-data="{ activeSlide: 0 }">
        @foreach ($events as $event)

            <a x-transition x-show="{{ $loop->index }} == activeSlide" href="{{ $event->url }}" class="">

                @if ($event->video_thumbnail)
                    {!! $event->video_thumbnail !!}

                    @if ($event->video_conversions)
                        <video
                            onplay="(function(e){e.classList.remove('opacity-0');e.classList.add('opacity-80') })(this)"
                            class="absolute inset-0 -z-10 h-full w-full object-cover opacity-0" playsinline muted
                            autoplay loop>
                            @foreach ($event->video_conversions->{'1280x720'} as $format => $url)
                                <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                            @endforeach
                        </video>
                    @endif
                @elseif ($event->src)
                    <x-image :src="$event->src" :srcset="$event->srcset"
                        class="opacity-80 absolute inset-0 h-full w-full object-cover object-center lg:-z-10" />
                @endif

                <div class="transform text-white gap-3 flex flex-row container absolute bottom-8 z-50"
                    :class="scrolled ? '' : 'opacity-0 translate-y-8 lg:opacity-100 lg:translate-y-0'">
                    <div class="type-xs-mono w-16 mb-8 lg:mb-4">
                        <button
                            x-on:click.prevent="activeSlide = (activeSlide > 0) ? ( activeSlide - 1) : {{ $loop->count - 1 }} ">Prev</button>
                        <button
                            x-on:click.prevent="activeSlide = (activeSlide < {{ $loop->count - 1 }}) ?  (activeSlide + 1) : 0">Next</button>
                        <div>{{ $event->status }}</div>

                    </div>
                    <div class="">
                        <div class="mb-4">
                            @foreach ($event->strands as $strand)
                                <div :style="`background-color: {{ $strand->color }}`"
                                    class="type-xs-mono mr-2 inline-block whitespace-nowrap !leading-none rounded pt-1.5 pb-1 pl-2 pr-2">
                                    Part of <strong class="font-sans font-bold">{{ $strand->name }}</strong>
                                </div>
                            @endforeach
                        </div>
                        <h3 class="type-medium md:type-regular inline-block">{{ $event->name }}</h3>
                        <x-certificate :certificate="$event->certificate_age_guidance" :dark="true" />
                    </div>

                </div>
            </a>
        @endforeach

    </div>
