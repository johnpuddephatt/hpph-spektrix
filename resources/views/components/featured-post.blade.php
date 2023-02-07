@if ($featured_post)
    <div class="bg-sand-dark relative py-16">
        <div class="bg-black absolute inset-0 h-1/2"></div>
        <div class="relative max-w-7xl container">
            <a href="{{ $featured_post->url }}" class="rounded bg-sand flex flex-col items-center lg:flex-row">
                @if ($featured_post->image)
                    {!! $featured_post->image !!}
                @else
                    <div class="aspect-video w-3/4 rounded bg-gray-light lg:w-1/2"></div>
                @endif

                <div class="w-3/4 p-8 text-center lg:w-1/2">
                    <h2 class="type-medium">{{ $featured_post->title }}</h2>
                    <p class="type-medium !font-normal">{{ $featured_post->introduction }}</p>

                    <div class="type-xs-mono">{{ $featured_post->created_at }}</div>
                    <x-post-tags class="type-xs-mono" :tags="$featured_post->tagsTranslated" />

                    <span class="inline-block rounded-full border">

                        @svg('arrow-right', 'rotate -rotate-45 p-3 h-10 w-10')
                    </span>
                </div>
            </a>

        </div>

    </div>
@endif
