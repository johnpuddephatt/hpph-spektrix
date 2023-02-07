<div class="mb-24">
    <div class="container flex flex-row items-center gap-2 py-12">
        <div class="type-xs-mono">Filter:</div>
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

    @include('components.posts-grid')

    {{ $posts->links() }}

</div>
