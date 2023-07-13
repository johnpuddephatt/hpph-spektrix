@if ($layout->statement)
    <div class="bg-yellow pt-10 pb-16">
        <div class="container max-w-4xl mx-auto text-center">
            <p class="type-xs-mono mb-12">{{ $layout->heading }}</p>
            <h2 class="type-regular md:type-medium">{{ $layout->statement }}</h2>
        </div>
    </div>
@endif

@if ($layout->shuffled_images && count($layout->shuffled_images))

    <div x-data="carousel" class="w-full overflow-hidden bg-black pb-12 lg:pb-36">
        <div class="absolute left-0 right-0 h-48 bg-yellow"></div>
        <div :class="{ 'opacity-0': !initialised }" id="carousel-wrapper" x-intersect:enter="config.inView = true"
            x-intersect:leave="config.inView = false" @resize.window="init(); slideCarousel(config);"
            @scroll.window="slideCarousel(config)">
            <div class="images">
                @foreach ($layout->shuffled_images as $image)
                    {!! $image->img('square')->attributes([
                        'data-width' => '35vw',
                        'class' => 'absolute left-0 block w-[66.667vw] origin-center rounded lg:w-[50vw] xl:w-[33.3vw]',
                    ]) !!}
                @endforeach
            </div>
        </div>

    </div>
@endif
