    <div id="slider-wrapper" class="absolute inset-0 flex flex-col justify-end pb-8 lg:right-[55%]"
        x-data='{ activeSlide: 0, slides: {{ $events }} }' x-init="$refs.seasonWrapper.style.width = $refs.seasonWrapper.firstElementChild.clientWidth + 'px';
        $watch('activeSlide', value => $nextTick(() => {
            $refs.seasonWrapper.style.width = $refs.seasonWrapper.firstElementChild.clientWidth + 'px';
        }))">
        @foreach ($events as $event)
            @if ($event->featuredImage)
                <x-image x-show="{{ $loop->index }} == activeSlide" :src="$event->featuredImage->getUrl('square')" :srcset="$event->featuredImage->getSrcset('square')"
                    class="absolute inset-0 -z-10 h-full w-full object-cover object-center" />
            @endif
        @endforeach

        <div class="pointer-events-none absolute top-0 bottom-0 right-0 w-96 bg-gradient-to-l from-black to-transparent">
        </div>
        <div class="container relative z-10 text-white"">
            <div class="type-label mb-4">Showing today</div>
            <h3 class="type-h2" x-text="slides[activeSlide].name"></h3>
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
                                class="type-annotation border-current mr-2 inline-block whitespace-nowrap rounded border pt-1 pb-1 pl-2 pr-2">
                                <span
                                    class="bg-current relative -mt-0.5 mr-1 inline-block h-2 w-2 rounded-full"></span><span
                                    x-text="strand.name"></span>
                            </div>
                        </template>
                        <template x-for="season in slides[activeSlide].seasons">
                            <div x-cloak x-transition:enter="transition-all ease-out duration-300"
                                x-transition:enter-start="max-w-[0] opacity-0" x-transition:enter-end="max-w-[10em]"
                                x-transition:leave="transition-all ease-in duration-300"
                                x-transition:leave-start="max-w-[10em]" x-transition:leave-end="max-w-[0] opacity-0"
                                class="type-annotation mr-2 inline-block whitespace-nowrap rounded border border-white pt-1 pb-1 pl-2 pr-2 text-white">
                                <span
                                    class="relative -mt-0.5 mr-1 inline-block h-2 w-2 rounded-full bg-white"></span><span
                                    x-text="season.name"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <span class="mr-2 h-1 w-1 rounded-full bg-white"></span>


            </div>


            <!-- Buttons -->
            <div class="relative z-10 mt-8 flex gap-8">
                <template x-for="(slide, index) in slides" :key="slide.id">
                    <button
                        class="h-2.5 w-2.5 overflow-hidden rounded-full border border-white transition-colors duration-200 ease-out hover:bg-white hover:shadow-lg"
                        :class="{
                            'bg-white': activeSlide === index,
                            'bg-transparent': activeSlide !== index
                        }"
                        x-on:click="activeSlide = index"></button>
                </template>
            </div>
        </div>
    </div>
