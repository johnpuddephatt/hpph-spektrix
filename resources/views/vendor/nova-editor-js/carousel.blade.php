<div class="my-16 relative" x-data="{ timeout: null, scrollPosition: 0, showControls: {{ count($images) > 2 }}, showPreviousControl: true, showNextControl: true }"
    x-effect="$refs.scroller.scrollLeft = scrollPosition; showPreviousControl = !(scrollPosition == 0); showNextControl = !(scrollPosition >= $refs.scroller.scrollWidth - $refs.scroller.clientWidth);">
    <div class="{{ $width != 'full' ? '-mx-4' : '' }} overflow-hidden bg-sand-light px-4 py-6">
        <div x-ref="scroller"
            @scroll="clearTimeout(timeout);     timeout = setTimeout(() => {scrollPosition = $el.scrollLeft}, 50)"
            class="@if (count($images) < 3) @else @endif lg:flex-row gap-4 lg:gap-5 flex-col flex-row gap-5 scroll-smooth ml-[calc((100vw-100%)/-2)] flex w-screen overflow-x-auto px-[calc((100vw-100%)/2)] scrollbar-hide">
            @foreach ($images as $image)
                <figure
                    class="@if (count($images) < 3) w-full @elseif (count($images) == 2) w-full @else flex-none @endif">

                    <img src="{{ $image['url'] }}"
                        class="@if (count($images) > 2) h-[24rem] lg:h-[32em] w-auto @elseif(count($images) == 2) w-full h-auto lg:max-w-[80vw] lg:h-[calc(100%-2rem)] object-cover @else w-full h-auto @endif block rounded">

                    @if ($image['caption'])
                        <figcaption class="type-xs-mono pt-4">
                            {{ $image['caption'] }}
                        </figcaption>
                    @endif
                </figure>
            @endforeach
        </div>
    </div>

    <div x-show="showControls" class="text-white absolute bottom-1 right-4">
        <button :class="{ 'opacity-25': !showPreviousControl }" :disabled="!showPreviousControl"
            @click="scrollPosition = Math.max(0, scrollPosition - window.innerWidth/1.5)"
            class="bg-black rounded-full py-1 px-1">
            @svg('chevron-right', 'rotate-180 h-8 w-8')
        </button>
        <button :class="{ 'opacity-25': !showNextControl }" :disabled="!showNextControl"
            @click="scrollPosition = Math.min($refs.scroller.scrollWidth - $refs.scroller.clientWidth, scrollPosition + window.innerWidth/1.5)"
            class="bg-black rounded-full py-1 px-1">
            @svg('chevron-right', 'h-8 w-8')
        </button>
    </div>
</div>
