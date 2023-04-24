<div id="team" class="py-16 bg-black text-white">
    <div class="container lg:flex flex-row pb-16">
        <h3 class="type-medium mb-4 lg:w-1/2 text-yellow">{{ $layout->title }}</h3>
        <p class="max-w-lg">{{ $layout->subtitle }}</p>
    </div>

    <div x-data="{ swiper: null, showControls: false, showPreviousControl: true, showNextControl: true }" x-init="swiper = new Swiper($refs.container, {
        loop: false,
        slidesPerView: 4,
        spaceBetween: 15,
        centerInsufficientSlides: true,
    
        on: {
            progress: function() {
                showPreviousControl = !this.isBeginning;
                showNextControl = !this.isEnd;
                showControls = !(this.isBeginning && this.isEnd);
            }
        },
    
        breakpoints: {
            640: {
                slidesPerView: 1.5,
            },
            768: {
                slidesPerView: 2.5,
    
            },
            1024: {
                slidesPerView: 4,
            },
            1280: {
                slidesPerView: 6,
            },
            1536: {
                slidesPerView: 8,
            },
        },
    })" class="relative container max-w-none mx-auto">

        <div class="swiper-container w-full overflow-hidden" x-ref="container">
            <div class="swiper-wrapper w-full">

                @foreach ($layout->team as $user)
                    <a x-data="{ shown: true }"
                        class="swiper-slide group block text-center hover:opacity-60 !transition !duration-500"
                        :class="{ 'max-lg:opacity-30': !shown, '!opacity-100': shown }"
                        x-intersect:enter.full.margin.500.0="shown = true"
                        x-intersect:leave.full.margin.500.0="shown = false"
                        @click="if(!shown) { swiper.slideTo({{ $loop->index }}); $event.preventDefault(); }"
                        href="{{ $user->url }}">
                        {!! $user->featuredImage->img('portrait')->attributes(['class' => 'rounded block mb-8']) !!}
                        <h3 class="type-xs-mono transition group-hover:text-yellow text-white">{{ $user->name }}</h3>
                        <p class="type-xs-mono transition group-hover:text-white text-gray-medium">
                            {{ $user->role_title }}</p>
                    </a>
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
