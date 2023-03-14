@props(['featured_post', 'dark' => false])

@if ($featured_post)

    <div {{ $attributes->class(['relative']) }}>
        <div class="bg-black absolute inset-0 h-1/2"></div>
        <div class="relative max-w-8xl container">
            <a href="{{ $featured_post->url }}"
                class="{{ $dark ? 'bg-black-light text-white' : 'bg-sand' }} rounded overflow-hidden block lg:flex flex-col items-center lg:flex-row">
                @if ($featured_post->image)
                    {!! $featured_post->image->img('landscape')->attributes(['class' => 'w-full block lg:w-1/2 aspect-video lg:aspect-auto']) !!}
                @endif

                <div class="flex flex-col aspect-video lg:block lg:aspect-auto lg:py-8 p-8 lg:w-1/2 mx-auto lg:max-w-md">
                    <div class="lg:min-h-[9rem]">
                        <h2 class="type-regular lg:type-medium">{{ $featured_post->title }}</h2>
                        @if ($featured_post->subtitle)
                            <p class="type-regular lg:type-medium !font-normal mb-4">{{ $featured_post->subtitle }}</p>
                        @endif
                    </div>
                    <p class="">{{ $featured_post->summary }}</p>

                    <div class="mt-auto flex flex-row gap-4 pt-2 justify-between align-bottom">
                        <div>
                            <div class="type-xs-mono">{{ $featured_post->date }}</div>
                            <x-post-tags class="type-xs-mono" :tags="$featured_post->tags_translated" />
                        </div>

                        @svg('arrow-right', 'rounded-full border rotate -rotate-45 p-2.5 h-9 w-9')
                    </div>
                </div>
            </a>
        </div>
    </div>
@endif
