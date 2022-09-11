<div>
    <div class="container flex flex-row items-center gap-2 py-12">
        <div class="type-label">Filter:</div>
        <button wire:click="$set('selected_tag', null)"
            class="{{ $selected_tag === null ? 'bg-black text-white' : '' }} rounded border border-gray-light p-1 pl-2 pr-3 before:mr-1.5 before:inline-block before:h-3 before:w-3 before:rounded-full before:border before:bg-white">
            All
        </button>
        @foreach ($tags as $tag)
            <button wire:click="$set('selected_tag', '{{ $tag->name }}')"
                class="{{ $selected_tag === $tag->name ? 'bg-black text-white' : '' }} rounded border border-gray-light p-1 pl-2 pr-3 before:mr-1.5 before:inline-block before:h-3 before:w-3 before:rounded-full before:border before:bg-white">
                {{ $tag->name }}
            </button>
        @endforeach
    </div>

    <div class="container grid gap-x-6 gap-y-16 lg:grid-cols-2 xl:grid-cols-3">
        @foreach ($posts as $post)
            <a href="{{ route('post.show', ['post' => $post->slug]) }}" class="flex flex-col">
                <p class="type-label mb-2">
                    {{ $post->created_at->format('j F Y') }}
                    @if ($post->tags->count())
                        &bullet;
                        <x-post-tags :tags="$post->tags" />
                    @endif
                </p>
                @if ($post->featuredImage)
                    {!! $post->featuredImage->img('landscape', ['class' => 'rounded block'])->toHtml() !!}
                @else
                    <div class="rounded bg-gray pt-[66.7%]"></div>
                @endif
                <h3 class="type-subtitle mt-4 mb-1">{{ $post->title }}</h3>
                <p class="pb-4">{{ $post->introduction }}</p>

                <div class="mt-auto flex flex-row items-center gap-2 border-t border-gray pt-2">
                    <img class="h-auto w-6 rounded lg:w-10" src="{!! url($post->user->avatar) !!}">
                    <p class="type-label">Written by <br>{{ $post->user->name }}</p>
                </div>
            </a>
        @endforeach
    </div>
    {{ $posts->links() }}

</div>
