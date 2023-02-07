@if ($reviews->count())
    <div class="bg-black flex flex-row py-24 text-white" x-data="{ activeReview: 0 }">

        @if ($reviews->count() > 1)
            <div class="pr-40 w-1/2 flex flex-col gap-16 items-end pt-12">
                <button aria-label="Previous review"
                    x-on:click.prevent="activeReview = (activeReview > 0) ? ( activeReview - 1) : {{ $reviews->count() - 1 }} ">@svg('chevron-down', 'block w-10 h-6 origin-center rotate-180')</button>
                <button aria-label="Next review"
                    x-on:click.prevent="activeReview = (activeReview < {{ $reviews->count() - 1 }}) ?  (activeReview + 1) : 0">@svg('chevron-down', 'block w-10 h-6')</button>
            </div>
        @endif
        <div class="relative min-h-[12em]">
            @foreach ($reviews as $review)
                <a href="{{ $review->url }}" class="transition block"
                    x-transition:enter="opacity-0 absolute top-24 left-0" x-transition:leave="opacity-0"
                    x-show="activeReview == {{ $loop->index }}">
                    <div class="max-w-5xl">
                        <div class="type-regular mb-8">
                            <div class="mb-8 flex flex-row gap-2">
                                @foreach (range(0, $review['rating']) as $rating)
                                    @svg('star', 'w-10 h-10')
                                @endforeach
                            </div>
                            <blockquote>
                                <p class="type-medium text-yellow mb-8 relative"><span
                                        class="right-full absolute">“</span>{{ $review['quote'] }}”</p>
                                @if (isset($review['publication_name']))
                                    <cite class="not-italic">{{ $review['publication_name'] }}</cite>
                                @endif
                            </blockquote>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
