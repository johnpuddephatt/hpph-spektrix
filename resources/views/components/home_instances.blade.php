<div class="bg-black py-12 text-white">
    <div class="container">
        <div class="type-xs-mono text-center mb-4">Screenings</div>
        <div class="type-regular lg:type-medium text-center"><span class="underline text-yellow">Upcoming</span> / <a
                class="hover:underline" href="{{ route('programme') }}">Full listings</a>
        </div>

        <div x-data="{ swiper: null, showControls: false, showPreviousControl: true, showNextControl: true }" x-init="swiper = new Swiper($refs.container, {
            loop: false,
            slidesPerView: 1.5,
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
                    slidesPerView: 1.5,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
                1280: {
                    slidesPerView: 4,
                },
                1536: {
                    slidesPerView: 6
                },
            },
        })" class="mt-12 lg:mt-24 relative max-w-none mx-auto">

            <div class="swiper-container border-t border-gray-dark pt-10 lg:pt-16 w-full overflow-hidden"
                x-ref="container">
                <div class="swiper-wrapper w-full">
                    @foreach ($page->content->instances as $instance)
                        <x-instance-card layout="home" class="swiper-slide" :instance="$instance" />
                    @endforeach
                </div>
            </div>

            <div class="mt-20 lg:mt-24 justify-center flex flex-row gap-4 border-t border-gray-dark text-white">
                <div x-show="showControls" class="-mt-7 bg-black border border-gray-dark rounded-full">
                    <button :class="{ 'opacity-25': !showPreviousControl }" :disabled="!showPreviousControl"
                        @click="swiper.slidePrev()" class="py-1 pl-6 pr-2">
                        @svg('chevron-right', 'rotate-180 h-8 w-8')
                    </button>
                    <button :class="{ 'opacity-25': !showNextControl }" :disabled="!showNextControl"
                        @click="swiper.slideNext()" class="py-1 pl-2 pr-6">
                        @svg('chevron-right', 'h-8 w-8')
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
