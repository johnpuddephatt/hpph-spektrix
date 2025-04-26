
@if($seasons->count())
             <div  x-cloak x-data="{ swiper: null, showControls: false, showPreviousControl: true, showNextControl: true, totalSlides: {{ count($seasons) }}, }" x-init="
             @if($layout->randomize)
             [...$refs.wrapper.querySelectorAll('.swiper-slide')]
            .sort((a, b) => Math.random() > 0.5 ? 1 : -1)
            .forEach(node => $refs.wrapper.appendChild(node));
            @endif
             swiper = new Swiper($refs.container, {
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
            slidesPerView:  Math.min(totalSlides, 3),
        },
        1280: {
slidesPerView:  Math.min(totalSlides, 3),        },
        1536: {
            slidesPerView:  Math.min(totalSlides, 4),
        },
    },
})" class="py-12 lg:py-16 bg-black relative max-w-none mx-auto">

    @if($layout->title)    
        <div class="type-xs-mono text-white  text-center mb-2">{{ $layout->title }}</div>
    @endif
    @if($layout->subtitle)
        <h2 class="type-regular text-white text-center lg:type-medium ">{{ $layout->subtitle }}</a></h2>
    @endif

    <div class="swiper-container pt-12 lg:pt-24 container  w-full overflow-hidden" x-ref="container">
        <div  x-ref="wrapper" class=" swiper-wrapper w-full">
            @foreach ($seasons as $season)
                 <a style="color: {{ $season->color }} !important;"
                     href="{{ route('season.show', ['season' => $season->slug]) }}"
                     class="!h-auto swiper-slide  text-white rounded   group  !flex flex-col items-start relative overflow-hidden">
                     @if ($season->featuredImage)
                     <div class="overflow-hidden rounded  bg-gray-dark">
                     <div class="aspect-[1.66667]">
                         {!! $season->featuredImage->img('landscape')->attributes([
                             'data-width' => '600px',
                             'loading' => 'lazy',
                             'class' =>
                                 ' absolute inset-0 block w-full   bg-gray opacity-50 group-hover:scale-105 lg:group-hover:opacity-20 duration-500 transition',
                         ]) !!}
                         </div>
                         </div>
                     @else
                         <div
                             class=" bg-gray-dark aspect-[1.66667] block w-full opacity-10 lg:group-hover:opacity-0 transition">
                         </div>
                     @endif

                         <div class="pb-4">
                         @if ($season->date_range)
                           <p
                         class="type-xs-mono my-4">
                         {{ $season->date_range }}</p>
                             
                    @endif
                   
                         <h3
                             class="type-medium  mb-4">
                             {{ $season->name }}</h3>

                     <p
                         class="type-xs-mono max-w-sm ">
                         {{ $season->short_description }}</p>
</div>

<span class="inline-block transition mt-auto ml-px rounded group-hover:bg-yellow group-hover:text-black border border-yellow text-yellow type-regular px-10 py-3">Learn more</span>

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
            <button :class="{ 'opacity-25': !showNextControl }" :disabled="!showNextControl" @click="swiper.slideNext()"
                class="py-1 pl-2 pr-6">
                @svg('chevron-right', 'h-8 w-8')
            </button>
        </div>
    </div>
</div>
@endif