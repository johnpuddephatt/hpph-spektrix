@if ($banner->enabled)
    @if ($banner->url)
        <a href="{{ $banner->url }}">
    @endif
    <div
        class="{{ $banner->height }} {{ $banner->text_color }} {{ $banner->bg_color }} relative flex flex-col items-center justify-center py-32">
        <x-image :src="$banner->src" :srcset="$banner->srcset" class="absolute inset-0 h-full w-full object-cover" />

        @if ($banner->overlay)
            <div class="fade-to-right absolute inset-0 lg:w-1/2"></div>
        @endif
        <div class="container relative">
            <div class="w-2/3 lg:w-2/5">
                <h2 class="type-medium mb-8">{{ $banner->title }}</h2>
                <p class="type-large">{{ $banner->subtitle }}</p>

                @if ($banner->url)
                    <div class="mt-8 block w-12 rounded-full bg-yellow text-black">
                        @svg('chevron-right', 'w-full h-auto p-0.5')
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($banner->url)
        </a>
    @endif

@endif
