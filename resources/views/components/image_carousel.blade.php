<div x-data="carousel" class="w-full overflow-hidden bg-yellow pb-16 lg:pb-36">
    <div :class="{ 'opacity-0': !initialised }" id="carousel-wrapper" x-intersect:enter="config.inView = true"
        x-intersect:leave="config.inView = false" @resize.window="init(); slideCarousel(config);"
        @scroll.window="slideCarousel(config)">
        <div class="images">
            @foreach ($block->gallery as $image)
                <x-image :src="$image->getUrl('portrait')" :srcset="$image->getSrcset('portrait')"
                    class="absolute left-0 block w-[66.667vw] origin-center rounded-3xl lg:w-[50vw] xl:w-[33.3vw]" />
            @endforeach
        </div>
    </div>
</div>
