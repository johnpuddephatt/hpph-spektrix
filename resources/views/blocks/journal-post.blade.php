@if ($layout->post)

    <div class="@if ($layout->dark) bg-black @else bg-sand-dark @endif relative py-16">
        @if ($layout->striped)
            <div class="bg-black absolute inset-0 h-1/2"></div>
        @endif
        <div class="relative max-w-8xl container">
            <a href="{{ $layout->post->url }}"
                class="{{ $layout->dark ? 'bg-black-light text-white' : 'bg-sand' }} rounded overflow-hidden block lg:flex flex-col items-center lg:flex-row">
                @if ($layout->post->featuredImage)
                    {!! $layout->post->featuredImage->img('wide')->attributes(['class' => 'w-full block lg:w-1/2 aspect-video lg:aspect-auto']) !!}
                @endif

                <div class="flex flex-col aspect-video lg:block lg:aspect-auto lg:py-8 p-8 lg:w-1/2 mx-auto lg:max-w-md">
                    <div class="lg:min-h-[9rem]">
                        <h2 class="type-regular lg:type-medium">{{ $layout->post->title }}</h2>
                        @if ($layout->post->subtitle)
                            <p class="type-regular lg:type-medium !font-normal mb-4">{{ $layout->post->subtitle }}</p>
                        @endif
                    </div>

                    <div class="mt-auto flex flex-row gap-4 pt-2 justify-between align-bottom">
                        <div>
                            <div class="type-xs-mono">{{ $layout->post->date }}</div>
                            <x-post-tags class="type-xs-mono" :tags="$layout->post->tags_translated" />
                        </div>

                        @svg('arrow-right', 'rounded-full border rotate -rotate-45 p-2.5 h-9 w-9')
                    </div>
                </div>
            </a>
        </div>
    </div>
@endif
