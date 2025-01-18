@props(['entries' => [], 'type' => 'instances', 'layout' => 'default', 'show_strand' => true, 'color' => null, 'strand' => null, 'season' => null])

<div x-cloak x-data="{ swiper: null, showControls: false, showPreviousControl: true, showNextControl: true, totalSlides: {{ count($entries) + ($strand || $season ? 1 : 0) }}, }" x-init="swiper = new Swiper($refs.container, {
    loop: false,

    slidesPerView: Math.min(totalSlides, 1.5),
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
            slidesPerView: Math.min(totalSlides, 1.5),
        },
        768: {
            slidesPerView: Math.min(totalSlides, 2),

        },
        1024: {
            slidesPerView: @if ($layout == 'home') 4 @else Math.min(totalSlides, 3) @endif,
        },
        1280: {
            slidesPerView: @if ($layout == 'home') 5 @else Math.min(totalSlides, 4) @endif,
        },
        1536: {
            slidesPerView: @if ($layout == 'home') 6 @else Math.min(totalSlides, 4) @endif,
        },
    },
})" class="mt-12 lg:mt-24 relative max-w-none mx-auto">
    <div class="swiper-container border-t border-gray-dark pt-10 lg:pt-16 w-full overflow-hidden" x-ref="container">
        <div class="swiper-wrapper w-full">
            @if ($strand)
                <div class="swiper-slide">
                    <x-strand.card-reactive :strand="$strand" :total_slides="count($entries) + 1" />
                </div>
            @elseif($season)
                <div class="swiper-slide">
                    <x-season.card-reactive :season="$season" :total_slides="count($entries) + 1" />
                </div>
            @endif

            @foreach ($entries as $entry)

            @if($type == 'instances')
                <x-instance-card @click="if(!shown) { swiper.slideTo({{ $loop->index }}); $event.preventDefault(); }"
                    x-data="{ shown: true }" class="hover:opacity-60 !transition !duration-500" ::class="{ 'max-lg:opacity-30': !shown, '!opacity-100': shown }"
                    x-intersect:enter.full.margin.500.0="shown = true"
                    x-intersect:leave.full.margin.500.0="shown = false" :layout="$layout" :show_strand="$show_strand"
                    :color="$color" :instance="$entry" />
            @elseif($type == 'events')
                <x-event-card-responsive @click="if(!shown) { swiper.slideTo({{ $loop->index }}); $event.preventDefault(); }"
                    x-data="{ shown: true }" class="hover:opacity-60 !transition !duration-500" ::class="{ 'max-lg:opacity-30': !shown, '!opacity-100': shown }"
                    x-intersect:enter.full.margin.500.0="shown = true"
                    x-intersect:leave.full.margin.500.0="shown = false" :layout="$layout" :show_strand="$show_strand"
                    :color="$color" :event="$entry" />
            @endif

            @endforeach


        </div>
    </div>

    <div class="mt-20 lg:mt-24 justify-center flex flex-row gap-4 border-t border-gray-dark text-white">
        <div x-show="showControls" class="-mt-7 bg-black border border-gray-dark rounded-full">
            <button :class="{ 'opacity-25': !showPreviousControl }" :disabled="!showPreviousControl"
                @click="swiper.slidePrev()" class="py-1 pl-6 pr-2">
                @svg('chevron-right', 'rotate-180 h-8 w-8')
            </button>
            <button :class="{ 'opacity-25': !showNextControl }" :disabled="!showNextControl" @click="swiper.slideNext()"
                class="py-1 pl-2 pr-6">
                @svg('chevron-right', 'h-8 w-8')
            </button>
        </div>
    </div>
</div>
