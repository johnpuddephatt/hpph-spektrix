@if (count($posts))
    <div class="bg-sand py-24" x-data="{ activePost: 0 }">
        <div class="relative">
            <div class="type-label transform pb-12 text-center lg:absolute lg:top-1/2 lg:-rotate-90 lg:pb-0">Journal
            </div>

            <div class="container mx-auto max-w-6xl">

                @foreach ($posts as $post)
                    <div class="flex flex-col items-center lg:flex-row" x-show="activePost == {{ $loop->index }}">
                        @if ($post->image)
                            {!! $post->image !!}
                        @else
                            <div class="aspect-video w-3/4 rounded bg-gray-light lg:w-1/2"></div>
                        @endif

                        <div class="w-3/4 p-8 text-center lg:w-1/2">
                            <div class="mb-0.5 mt-4 font-bold">Journal</div>
                            <div class="">{{ $post->created_at }}</div>
                            <h2 class="type-h5 my-8">{{ $post->title }}</h2>
                            <p class="mx-auto mb-6 max-w-md">{!! $post->introduction !!}</p>
                            <a class="inline-block h-12 w-12 rounded-full bg-yellow"
                                href="{{ route('post.show', ['post' => $post->slug]) }}">
                                @svg('right-chevron', 'm-1 h-10 w-10')
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if (count($posts) > 1)
            <div class="relative z-10 mt-12 flex justify-center gap-4">
                @foreach ($posts as $post)
                    <button
                        class="h-2.5 w-2.5 overflow-hidden rounded-full border border-gray-dark transition-colors duration-200 ease-out hover:bg-gray-dark hover:shadow-lg"
                        :class="{
                            'bg-gray-dark': activePost === {{ $loop->index }},
                            'bg-transparent': activePost !== {{ $loop->index }}
                        }"
                        x-on:click="activePost = {{ $loop->index }}"></button>
                @endforeach
            </div>
        @endif
    </div>
@endif
