<div class="pb-24 bg-sand-dark">
    <div class="container flex flex-row items-center gap-2 py-12">
        <div class="type-xs-mono">Filter:</div>

        @if ($selected_tag)
            <button wire:key="remove-tag-filter" aria-label="Remove filter for {{ $selected_tag }}"
                class="type-xs-mono cursor-default rounded bg-yellow hover:bg-yellow-dark pt-2 py-1.5 px-3"
                wire:click="$set('selected_tag', null)">

                {{ $tags->firstWhere('slug', $selected_tag)->name }}
                @svg('plus', 'rotate-45 align-top inline-block ml-1 w-3 h-3')</button>
        @else
            @if (count($tags))

                <button x-on:click="$refs.tagdialog.showModal()"
                    class="type-xs-mono cursor-default rounded bg-sand hover:bg-sand-dark pt-2 py-1.5 px-3">
                    Filter
                    @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                <dialog x-ref="tagdialog" x-on:click.self="$refs.tagdialog.close()"
                    class="overflow-visible py-16 opacity-0 open:opacity-100 transition max-w-3xl px-16 rounded fixed top-1/2 m-0 w-full left-1/2 bg-sand p-12 z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
                    <form class="max-w-md mx-auto" method="dialog">
                        <h3
                            class="type-xs-mono lg:block top-[45%] lg:absolute lg:right-full origin-bottom lg:translate-x-full lg:-rotate-90 whitespace-nowrap">
                            Filter by tag</h3>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach ($tags as $tag)
                                <button wire:click="$set('selected_tag', '{{ $tag->name }}')"
                                    class="{{ $selected_tag === $tag->name ? 'bg-black text-white' : '' }} rounded border border-gray-light p-1 pl-2 pr-3 before:mr-1.5 before:inline-block before:h-3 before:w-3 before:rounded-full before:border before:bg-white">
                                    {{ $tag->name }}
                                </button>
                            @endforeach
                        </div>
                        <button aria-label="Cancel" value="cancel"
                            class="type-xs-mono absolute top-full mt-4 left-1/2 !leading-none -translate-x-1/2 flex flex-row items-center rounded-full text-white bg-black-light pr-4">
                            @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                            Close
                        </button>
                    </form>
                </dialog>

            @endif
        @endif
    </div>

    @include('components.journal-grid')

    {{ $posts->links() }}

</div>
