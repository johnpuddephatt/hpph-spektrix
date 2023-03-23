@if (count($layout->posts))

    <div class="bg-sand-dark py-16">
        <div class="container">
            <div class="type-xs-mono text-center mb-2">Latest</div>
            <h2 class="type-regular lg:type-medium mb-8 lg:mb-16 text-center">Stories from our <a class="underline"
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
            })" class="relative max-w-none mx-auto">

                <div class="swiper-container w-full overflow-hidden" x-ref="container">
                    <div class="swiper-wrapper w-full">
                        @foreach ($layout->posts as $post)
                            <x-journal-card class="swiper-slide w-1/3" :post="$post" />
                        @endforeach
                    </div>
                </div>

                <div x-show="showControls"
                    class="mt-8 lg:mt-24 justify-center flex flex-row gap-4 border-t border-gray-light text-black">
                    <div class="-mt-6 bg-sand-dark flex flex-row border border-gray-light rounded-full">
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
