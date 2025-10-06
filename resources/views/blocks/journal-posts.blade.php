@if (count($layout->posts))

    <div class="relative bg-sand-dark py-16">
        <div class="container">
            <div class="type-xs-mono mb-2 text-center">Latest</div>
            <h2 class="type-regular lg:type-medium mb-8 text-center lg:mb-16">Stories from our <a class="underline"
                    href="/journal/">journal</a>
            </h2>

            <div x-data="{ swiper: null, showControls: false, showPreviousControl: true, showNextControl: true }" x-init="swiper = new Swiper($refs.container, {
                loop: false,
                slidesPerView: 1,
                spaceBetween: 15,
                centerInsufficientSlides: true,
            
                on: {
                    progress: function() {
                        showPreviousControl = !this.isBeginning;
                        showNextControl = !this.isEnd;
                        showControls = !this.isLocked;
                    }
                },
            
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                    },
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            })" class="relative mx-auto max-w-none">

                <div class="swiper-container w-full overflow-hidden" x-ref="container">
                    <div class="swiper-wrapper w-full">
                        @foreach ($layout->posts as $post)
                            <x-journal-card class="swiper-slide w-1/3" :post="$post" />
                        @endforeach
                    </div>
                </div>

                <div x-show="showControls"
                    class="mt-8 flex flex-row justify-center gap-4 border-t border-gray-light text-black lg:mt-24">
                    <div class="-mt-6 flex flex-row rounded-full border border-gray-light bg-sand-dark">
                        <button :class="{ 'opacity-25': !showPreviousControl }" :disabled="!showPreviousControl"
                            @click="swiper.slidePrev()" class="block py-1 pl-6 pr-2">
                            @svg('chevron-right', 'rotate-180 h-8 w-8 block')
                        </button>
                        <button :class="{ 'opacity-25': !showNextControl }" :disabled="!showNextControl"
                            @click="swiper.slideNext()" class="block py-1 pl-2 pr-6">
                            @svg('chevron-right', 'h-8 w-8 block')
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endif
