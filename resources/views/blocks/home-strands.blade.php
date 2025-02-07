             <div class="pb-12" x-cloak x-data="{ swiper: null, showControls: false, showPreviousControl: true, showNextControl: true, totalSlides: {{ count($strands) }}, }" x-init="
             [...$refs.wrapper.querySelectorAll('.swiper-slide')]
  .sort((a, b) => Math.random() > 0.5 ? 1 : -1)
  .forEach(node => $refs.wrapper.appendChild(node));
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
})" class="mt-12 lg:mt-24 relative max-w-none mx-auto">
    <div class="swiper-container container border-t border-gray-dark pt-10 lg:pt-16 w-full overflow-hidden" x-ref="container">
        <div  x-ref="wrapper" class=" swiper-wrapper w-full">
            @foreach ($strands as $strand)
                 <a style="color: {{ $strand->color }} !important;"
                     href="{{ route('strand.show', ['strand' => $strand->slug]) }}"
                     class="swiper-slide aspect-square min-h-72  group   block relative overflow-hidden text-center">

                     @if ($strand->featuredImage)
                         {!! $strand->featuredImage->img('landscape')->attributes([
                             'data-width' => '600px',
                             'loading' => 'lazy',
                             'class' =>
                                 'absolute h-full inset-0 object-cover object-center block w-full opacity-50 group-hover:scale-105 lg:group-hover:opacity-20 duration-500 transition',
                         ]) !!}
                     @else
                         <div
                             class="absolute h-full inset-0 bg-white object-cover object-center block w-full opacity-10 lg:group-hover:opacity-0 transition">
                         </div>
                     @endif

                     @if ($strand->logo)
                         @icon($strand->logo, ' group-hover:delay-[0ms] delay-100 lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-64 lg:w-72 max-w-full px-8')
                     @else
                         <h3
                             class="type-h4 lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-72 max-w-full px-8">
                             {{ $strand->name }}</h3>
                     @endif
                     <p
                         class="type-xs-mono w-full px-8 max-w-xs lg:px-0 lg:group-hover:opacity-100 lg:opacity-0 transition lg:group-hover:translate-y-1/2 left-1/2 transform -translate-x-1/2 absolute bottom-6 lg:bottom-1/2 mx-auto lg:w-64">
                         {{ $strand->short_description }}</p>

                     @svg('arrow-right', ' group-hover:delay-50 hidden lg:inline-block absolute bottom-8 -translate-x-1/2 left-1/2 transition w-9 h-9 p-2 rounded-full text-transparent group-hover:text-black bg-yellow transform origin-center group-hover:scale-100 scale-[0.4]', ['style' => 'background-color: ' . $strand->color])

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
