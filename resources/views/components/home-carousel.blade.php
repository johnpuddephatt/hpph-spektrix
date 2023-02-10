@if ($page->content->values->statement)
    <div class="bg-yellow pt-10 pb-16">
        <div class="container max-w-7xl text-center">
            <p class="type-xs-mono mb-12">Hello</p>
            <h2 class="type-regular md:type-large">{{ $page->content->values->statement }} </h2>
        </div>
    </div>
@endif

@if (count((array) $page->content->values->images))
    <div x-data="carousel" class="w-full overflow-hidden bg-black pb-16 lg:pb-36">
        <div class="absolute left-0 right-0 h-24 bg-yellow"></div>
        <div :class="{ 'opacity-0': !initialised }" id="carousel-wrapper" x-intersect:enter="config.inView = true"
            x-intersect:leave="config.inView = false" @resize.window="init(); slideCarousel(config);"
            @scroll.window="slideCarousel(config)">
            <div class="images">
                @foreach ($page->content->values->images as $image)
                    <x-image :src="$image->src" :srcset="$image->srcset"
                        class="absolute left-0 block w-[66.667vw] origin-center rounded lg:w-[50vw] xl:w-[33.3vw]" />
                @endforeach
            </div>
        </div>

        @if ($page->content->values->link_text)
            <a class="block text-center mt-16" href="{{ $page->content->values->link_url }}">
                <p class="type-xs-mono text-white">{{ $page->content->values->link_text }}
                </p>
                @svg('plus', 'mt-4 inline-block w-10 h-10 bg-gray-dark rounded-full p-2 text-gray-light')
            </a>
        @endif

    </div>

@endif
