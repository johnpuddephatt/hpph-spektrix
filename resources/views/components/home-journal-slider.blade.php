<div id="journal-wrapper" x-cloak
    class="container absolute bottom-0 right-0 z-10 mb-8 hidden w-[calc(25%+2em)] flex-row !pl-0 lg:flex"
    x-data="{ activeSlide: 0 }">

    <div x-show="{{ $posts->count() }} > 1" class="relative z-10 flex w-8 flex-col items-center justify-center gap-4">
        @foreach ($posts as $post)
            <button
                class="h-2.5 w-2.5 overflow-hidden rounded-full border border-white transition-colors duration-200 ease-out hover:bg-white hover:shadow-lg"
                :class="{
                    'bg-white': activeSlide === {{ $loop->index }},
                    'bg-transparent': activeSlide !== {{ $loop->index }}
                }"
                x-on:click="activeSlide = {{ $loop->index }}"></button>
        @endforeach

        <div class="type-label origin-center-left mt-auto -rotate-90 transform whitespace-nowrap pl-8 text-white">
            <span x-text="activeSlide + 1"></span> / <span>{{ $posts->count() }}</span>
        </div>
    </div>
    <div class="w-full border-l-[0.5px] border-gray-light pl-4">
        <div class="relative z-10 -mt-1 text-white">
            @foreach ($posts as $post)
                <div x-show="{{ $loop->index }} == activeSlide" class="transform transition"
                    x-transition:enter="delay-200 duration-500" x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:leave="duration-500 absolute w-full top-0"
                    x-transition:leave-end="opacity-0 -translate-y-4 ">
                    <div class="type-label mb-6">Journal • {{ $post->created_at->format('d M') }}</div>
                    <h3 class="type-subtitle">{{ $post->title }}</h3>
                    <x-image class="mt-12 rounded" :src="$post->featuredImage->getUrl('landscape')" :srcset="$post->featuredImage->getSrcset('landscape')" />
                </div>
            @endforeach
        </div>
    </div>
</div>
