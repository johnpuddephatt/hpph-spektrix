    <div id="slider-wrapper"
        class="relative inset-0 mt-[50vh] flex h-screen flex-col justify-end pb-8 lg:absolute lg:right-[55%] lg:mt-0 lg:h-auto"
        x-data='{ activeSlide: 0, slides: {{ json_encode($events) }} }' x-init="$watch('activeSlide', value => $nextTick(() => {
            $refs.seasonWrapper.style.width = $refs.seasonWrapper.firstElementChild.clientWidth + 'px';
        }))">
        @foreach ($events as $event)
            @if ($event->src)
                <x-image x-show="{{ $loop->index }} == activeSlide" :src="$event->src" :srcset="$event->srcset"
                    class="absolute inset-0 h-full w-full object-cover object-center lg:-z-10" />
            @endif
        @endforeach

        <div
            class="pointer-events-none absolute left-0 top-0 right-0 h-64 w-full bg-gradient-to-b from-black to-transparent lg:left-auto lg:bottom-0 lg:h-full lg:w-96 lg:bg-gradient-to-l">
        </div>
        <a :href="`/films/${slides[activeSlide].slug }`" class="container relative z-10 block text-white"">
            <div class="type-label mb-4" x-text="slides[activeSlide].status"></div>
            <h3 class="type-h3 lg:type-h2" x-text="slides[activeSlide].name"></h3>
            <div class="mt-4 flex flex-row items-center">
                <div class="mr-2 inline-block rounded bg-gray-dark py-1 px-2 font-mono text-white"
                    x-text="slides[activeSlide].certificate_age_guidance"></div>

                <div x-ref="seasonWrapper" class="flex overflow-hidden transition-all duration-200">
                    <div class="flex-shrink-0 whitespace-nowrap">
                        <template x-for="strand in slides[activeSlide].strands">
                            <div x-cloak x-transition:enter="transition-all ease-out duration-300"
                                :style="`color: ${strand.color}`" x-transition:enter-start="max-w-[0] opacity-0"
                                x-transition:enter-end="max-w-[10em]"
                                x-transition:leave="transition-all ease-in duration-300"
                                x-transition:leave-start="max-w-[10em]" x-transition:leave-end="max-w-[0] opacity-0"
                                class="type-annotation mr-2 inline-block whitespace-nowrap rounded border border-current pt-1 pb-1 pl-2 pr-2">
                                <span
                                    class="relative -mt-0.5 mr-1 inline-block h-2 w-2 rounded-full bg-current"></span><span
                                    x-text="strand.name"></span>
                            </div>
                        </template>

                    </div>
                </div>

                <!-- <span class="mr-2 h-1 w-1 rounded-full bg-white"></span> -->
            </div>
        </a>

        <!-- Buttons -->
        @if (count($events) > 1)
            <div class="relative z-10 mt-8 flex gap-8 px-5 2xl:px-6">
                @foreach ($events as $event)
                    <button
                        class="h-2.5 w-2.5 overflow-hidden rounded-full border border-white transition-colors duration-200 ease-out hover:bg-white hover:shadow-lg"
                        :class="{
                            'bg-white': activeSlide === {{ $loop->index }},
                            'bg-transparent': activeSlide !== {{ $loop->index }}
                        }"
                        x-on:click="activeSlide = {{ $loop->index }}"></button>
                @endforeach
            </div>
        @endif
    </div>
