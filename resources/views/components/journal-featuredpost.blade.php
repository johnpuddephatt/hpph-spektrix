@if ($featured_post)
    <div class="bg-sand-dark relative py-16">
        <div class="bg-black absolute inset-0 h-1/2"></div>
        <div class="relative max-w-8xl container">
            <a href="{{ $featured_post->url }}"
                class="rounded overflow-hidden bg-sand block lg:flex flex-col items-center lg:flex-row">
                @if ($featured_post->image)
                    <x-image class="lg:w-1/2 aspect-video lg:aspect-auto" :src="$featured_post->image->src" :srcset="$featured_post->image->srcset" />
                @endif

                <div class="flex flex-col aspect-video lg:block lg:aspect-auto lg:py-8 p-8 lg:w-1/2 mx-auto lg:max-w-md">
                    <div class="lg:h-36">
                        <h2 class="type-regular lg:type-medium">{{ $featured_post->title }}</h2>
                        <p class="type-regular lg:type-medium !font-normal">{{ $featured_post->introduction }}</p>
                    </div>
                    <div class="mt-auto flex flex-row gap-4 pt-2 justify-between align-bottom">
                        <div>
                            <div class="type-xs-mono">{{ $featured_post->date }}</div>
                            <x-post-tags class="type-xs-mono" :tags="$featured_post->tags_translated" />
                        </div>

                        @svg('arrow-right', 'rounded-full border rotate -rotate-45 p-2.5 h-10 w-10')
                    </div>
                </div>
            </a>
        </div>
    </div>
@endif
