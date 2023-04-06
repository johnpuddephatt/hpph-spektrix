@if ($reviews->count())
    <div class="container bg-black flex justify-between lg:justify-start flex-row-reverse lg:flex-row py-20 lg:py-24 text-white"
        x-data="{ activeReview: 0 }">

        <div class="flex-none pt-16 lg:pr-40 w-1/2 flex flex-col gap-12 lg:gap-16 items-end lg:pt-12">
            @if ($reviews->count() > 1)
                <button aria-label="Previous review"
                    x-on:click.prevent="activeReview = (activeReview > 0) ? ( activeReview - 1) : {{ $reviews->count() - 1 }} ">@svg('chevron-down', 'block w-6 h-4 lg:w-10 lg:h-6 origin-center rotate-180')</button>
                <button aria-label="Next review"
                    x-on:click.prevent="activeReview = (activeReview < {{ $reviews->count() - 1 }}) ?  (activeReview + 1) : 0">@svg('chevron-down', 'block w-6 h-4 lg:w-10 lg:h-6')</button>
            @endif
        </div>

        <div class="container relative min-h-[12em]">
            @foreach ($reviews as $review)
                <a href="{{ $review->url }}" class="transition block"
                    x-transition:enter="opacity-0 absolute top-24 left-0" x-transition:leave="opacity-0"
                    x-show="activeReview == {{ $loop->index }}">
                    <div class="max-w-5xl">
                        <div>
                            <div class="mb-8 flex flex-row gap-2">
                                @foreach (range(0, $review['rating']) as $rating)
                                    @svg('star', 'w-6 h-6 lg:w-10 lg:h-10')
                                @endforeach
                            </div>
                            <blockquote>
                                <p class="type-regular lg:type-medium text-yellow mb-10 relative"><span
                                        class="right-full absolute">“</span>{{ $review['quote'] }}”</p>
                                @if (isset($review['publication_name']))
                                    <cite class="lg:type-regular not-italic">{{ $review['publication_name'] }}</cite>
                                @endif
                            </blockquote>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
