@if ($layout->statement)
    <div class="bg-yellow pt-10 pb-16">
        <div class="container max-w-7xl text-center">
            <p class="type-xs-mono mb-12">{{ $layout->heading }}</p>
            <h2 class="type-regular md:type-large">{{ $layout->statement }}</h2>
        </div>
    </div>
@endif

@if (count($layout->shuffled_images))

    <div x-data="carousel" class="w-full overflow-hidden bg-black pb-12 lg:pb-36">
        <div class="absolute left-0 right-0 h-48 bg-yellow"></div>
        <div :class="{ 'opacity-0': !initialised }" id="carousel-wrapper" x-intersect:enter="config.inView = true"
            x-intersect:leave="config.inView = false" @resize.window="init(); slideCarousel(config);"
            @scroll.window="slideCarousel(config)">
            <div class="images">
                @foreach ($layout->shuffled_images as $image)
                    {!! $image->img('square')->attributes([
                            'data-width' => '50vw',
                            'class' => 'absolute left-0 block w-[66.667vw] origin-center rounded lg:w-[50vw] xl:w-[33.3vw]',
                        ]) !!}
                @endforeach
            </div>
        </div>

        @if ($layout->link_text)
            <a class="block text-center mt-16" href="{{ $layout->link_url }}">
                <p class="type-xs-mono text-white">{{ $layout->link_text }}
                </p>
                @svg('plus', 'mt-4 inline-block w-10 h-10 bg-white bg-opacity-[0.15] rounded-full p-2.5 text-white')
            </a>
        @endif
    </div>
@endif
