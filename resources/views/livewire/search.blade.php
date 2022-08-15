<div class="ml-6" x-data="{ open: false }">
    <button aria-label="Search for a film" title="Search for a film" class="relative rounded"
        :class="open ? 'bg-yellow text-black z-40' : ''"
        @click="open = !open; $nextTick(() => $refs.searchInput.focus()); $dispatch('menutoggled', open)">
        @svg('search', 'h-6 w-6 p-1 pt-1.5 pb-0.5 ')</button>

    <div @click.self="open = ! open; $dispatch('menutoggled', open)" x-show="open" x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-black bg-opacity-80 duration-300">
    </div>
    <div class="container fixed inset-0 left-auto z-20 flex h-screen w-full max-w-lg transform flex-col border-t-[5em] border-black bg-black text-white transition-all delay-100 duration-200"
        x-show="open" x-transition:enter-start="translate-x-full" x-transition:leave-end="translate-x-full">

        <input x-ref="searchInput"
            class="type-annotation w-full border-b-2 border-white bg-transparent py-6 focus-visible:outline-none"
            wire:model="search" type="text" placeholder="Search for a film" />

        <ul class="h-64 flex-1 divide-y divide-gray-medium overflow-y-auto">
            @foreach ($results as $result)
                <li><a class="block py-6 hover:bg-gray-dark"
                        href="{{ route('event.show', ['event' => $result->slug]) }}">{{ $result->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
