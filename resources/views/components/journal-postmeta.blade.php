@props(['dark' => false, 'link_tags' => false, 'post'])
<div {{ $attributes->class($dark ? 'text-gray-light' : 'text-black') }}>
    <div class="type-xs-mono flex flex-row gap-1.5 items-center">
        @svg('plus-square', 'h-3 w-3 inline-block mr-0.5  group-hover:text-yellow transition group-hover:bg-black')
        <span class="{{ $dark ? 'text-white' : 'text-dark' }}"> {{ $post->date }}</span>
    </div>

    @if (count($post->tags_translated))
        <div class="gap-1 flex flex-row items-center">
            @svg('bookmark', 'h-3 w-3 inline-block mr-0.5 group-hover:text-yellow transition')
            @foreach ($post->tags_translated ?? [] as $tag)
                @if ($link_tags)
                    <a href="{{ \App\Models\Page::getTemplateUrl('journal-page') }}?tag={{ $tag->slug_translated }}"
                        class="type-xs-mono {{ $dark ? 'bg-gray-dark hover:bg-black-light text-white' : 'bg-sand hover:bg-sand-dark text-black' }} px-1 py-0.5 rounded transition">
                        {{ $tag->name_translated }}</a>
                @else
                    <span class="type-xs-mono {{ $dark ? 'text-white' : 'text-black' }} px-1 py-0.5">
                        {{ $tag->name_translated }}</span>
                    @if (!$loop->last)
                        /
                    @endif
                @endif
            @endforeach
        </div>
    @endif
</div>
