@if ($post)
    <a href="{{ $post->url }}" class="group bg-sand-light rounded-r lg:rounded max-w-lg mt-4">
        <div class="p-4 pl-[20%] lg:pl-[25%]">
            <div
                class="type-xs-mono absolute right-full origin-right translate-x-8 lg:translate-x-12 -rotate-90 transform whitespace-nowrap">
                Journal</div>
            <div class="">

                @if ($post->featuredImage)
                    <div class="overflow-hidden w-64 rounded">
                        {!! $post->featuredImage->img('landscape')->attributes(['class' => 'group-hover:scale-105 transition duration-500 w-64 ']) !!}
                    </div>
                @else
                    <div class="w-64 aspect-video rounded bg-gray-light"></div>
                @endif

                <div class="">
                    <h2 class="type-regular mb-1 mt-3">{{ $post->title }}</h2>
                    <div class="type-xs-mono">
                        {{ $post->date }}
                        <!-- -->
                        @if (count($post->tags))
                            ,&nbsp;
                        @endif
                        @foreach ($post->tags as $tag)
                            <span>{{ $tag->name }}</span>
                        @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </a>

@endif
