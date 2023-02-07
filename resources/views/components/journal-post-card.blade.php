@if ($post)
    <a href="{{ $post->url }}" class="bg-sand-light rounded max-w-lg mt-4 p-4 pl-[25%]">
        <div class="type-xs-mono absolute right-full origin-right translate-x-12 -rotate-90 transform whitespace-nowrap">
            Journal</div>
        <div class="">

            @if ($post->image)
                {!! $post->image !!}
            @else
                <div class="w-64 aspect-video rounded bg-gray-light"></div>
            @endif

            <div class="">
                <h2 class="type-regular my-4">{{ $post->title }}</h2>
                <div class="type-xs-mono">
                    {{ $post->created_at->format('d M Y') }},

                    @foreach ($post->tags as $tag)
                        <span>{{ $tag->name }}</span>
                    @endforeach
                    </p>
                </div>
            </div>
        </div>
    </a>

@endif
