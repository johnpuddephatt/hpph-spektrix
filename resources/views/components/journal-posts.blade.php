@if (count($posts))

    <div class="bg-sand-dark py-24">
        <div class="relative">
            <div class="type-xs-mono text-center">Latest</div>
            <h2 class="type-medium mb-24 text-center">Stories from our <a class="underline" href="/journal/">journal</a>
            </h2>

            <div class="container mx-auto flex flex-row justify-center gap-8">

                @foreach ($posts as $post)
                    <a href="{{ $post->url }}" class="w-1/3 flex flex-col">
                        @if ($post->image)
                            {!! $post->image !!}
                        @else
                            <div class="= aspect-video rounded bg-gray-light"></div>
                        @endif

                        <div class="">
                            <h2 class="type-regular my-6">{{ $post->title }}</h2>
                            <div class="type-xs-mono">
                                @svg('plus-square', 'inline-block mr-1')
                                {{ $post->created_at }}
                            </div>

                            <div class="space-x-0.5">
                                @svg('bookmark', 'inline-block mr-1')

                                @foreach ($post->tagsTranslated as $tag)
                                    <span class="type-xs-mono bg-sand rounded p-1">{{ $tag->name_translated }}</span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
@endif
