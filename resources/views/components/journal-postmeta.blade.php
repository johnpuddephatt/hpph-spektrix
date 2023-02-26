@props(['dark' => false, 'post'])
<div {{ $attributes->class($dark ? 'text-gray-light' : 'text-black') }}>
    <div class="type-xs-mono flex flex-row gap-1.5 items-center">
        @svg('plus-square', 'h-3 w-3 inline-block mr-0.5')
        <span class="{{ $dark ? 'text-white' : 'text-dark' }}"> {{ $post->date }}</span>
    </div>

    <div class="gap-1 flex flex-row items-center">
        @svg('bookmark', 'h-3 w-3 inline-block mr-0.5')
        @foreach ($post->tags_translated ?? [] as $tag)
            <span
                class="type-xs-mono {{ $dark ? 'bg-gray-dark text-white' : 'bg-sand text-black' }} rounded px-1 py-0.5">{{ $tag->name_translated }}</span>
        @endforeach
    </div>
</div>
