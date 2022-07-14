    <div id="slider-wrapper" class="absolute inset-0 flex flex-col justify-end pb-8 lg:right-[55%]"
        x-data='{ activeSlide: 0, slides: {{ $events }} }'>
        @foreach ($events as $event)
            @if ($event->featuredImage)
                <x-image x-show="{{ $loop->index }} == activeSlide" :src="$event->featuredImage->getUrl('square')" :srcset="$event->featuredImage->getSrcset('square')"
                    class="absolute inset-0 -z-10 h-full w-full object-cover object-center" />
            @endif
        @endforeach

        <div class="to-transparent pointer-events-none absolute top-0 bottom-0 right-0 w-96 bg-gradient-to-l from-black">
        </div>
        <div class="container relative z-10 text-white"">
            <div class="type-label mb-4">Showing today</div>
            <h3 class="type-h2" x-text="slides[activeSlide].name"></h3>
            <div class="mt-4 flex flex-row items-center gap-2">
                <div class="inline-block rounded bg-gray-dark py-1 px-2 font-mono text-white"
                    x-text="slides[activeSlide].certificate_age_guidance"></div>

                <div class="flex flex-row gap-2">

                    <div x-cloak x-show="activeSlide == 0" x-transition:enter="transition-all ease-out duration-300"
                        x-transition:enter-start="max-w-[0] opacity-0" x-transition:enter-end="max-w-[10em]"
                        x-transition:leave="transition-all ease-in duration-300" x-transition:leave-start="max-w-[10em]"
                        x-transition:leave-end="max-w-[0] opacity-0"
                        class="type-annotation inline-block whitespace-nowrap rounded border border-orange pt-1 pb-1 pl-2 pr-2 text-orange">
                        <span class="relative -mt-0.5 mr-1 inline-block h-2 w-2 rounded-full bg-orange"></span>Hyde
                        &amp; Seek</span>
                    </div>


                    <div x-cloak x-show="activeSlide == 0 || activeSlide == 2"
                        x-transition:enter="transition-all ease-out duration-300"
                        x-transition:enter-start="max-w-[0] opacity-0" x-transition:enter-end="max-w-[10em]"
                        x-transition:leave="transition-all ease-in duration-300" x-transition:leave-start="max-w-[10em]"
                        x-transition:leave-end="max-w-[0] opacity-0"
                        class="type-annotation inline-block whitespace-nowrap rounded border border-pink pt-1 pb-1 pl-2 pr-2 text-pink">
                        <span
                            class="relative -mt-0.5 mr-1 inline-block h-2 w-2 rounded-full bg-pink"></span>BYOBaby</span>
                    </div>
                </div>

                <span class="mx-1 h-1 w-1 rounded-full bg-white"></span>


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
