<div>
    <div class="type-xs-mono flex flex-row gap-1.5 items-center">
        @svg('plus-square', 'h-3 w-3 inline-block mr-0.5')
        {{ $post->date }}
    </div>

    <div class="gap-1 flex flex-row items-center">
        @svg('bookmark', 'h-3 w-3 inline-block mr-0.5')
        @foreach ($post->tags_translated ?? [] as $tag)
            <span class="type-xs-mono bg-sand rounded px-1 py-0.5">{{ $tag->name_translated }}</span>
        @endforeach
    </div>
</div>
