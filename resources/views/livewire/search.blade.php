<div class="" x-data="{ open: false }">
    <button aria-label="Search for a film" title="Search for a film" class="relative block rounded"
        :class="{ 'bg-yellow text-black': open, 'max-lg:hidden': scrolled }"
        @click="open = !open; $nextTick(() => $refs.searchInput.focus()); $dispatch('menutoggled', open)">
        @svg('search', 'h-8 w-8 p-1 ')</button>

    <div @click.self="open = ! open; $dispatch('menutoggled', open)" x-show="open" x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-black bg-opacity-70 duration-300">
    </div>
    <div class="container fixed inset-0 left-auto z-20 flex h-screen w-full max-w-lg transform flex-col border-black bg-black p-12 text-white transition-all delay-100 duration-200"
        x-show="open" x-transition:enter-start="translate-x-full" x-transition:leave-end="translate-x-full">
        <div class="relative">
            <button class="absolute right-0 top-0 ml-auto" @click="open = ! open; $dispatch('menutoggled', open)"
                aria-label="Close search menu">@svg('plus', 'h-8 w-8 transform rotate-45 origin-center text-gray')</button>
            <h2 class="type-medium text-white">Search</h2>
            <input x-ref="searchInput"
                class="type-xs-mono w-full border-b-2 border-white bg-transparent py-6 focus-visible:outline-none"
                wire:model="search" type="text" placeholder="Search for a film" />

            <ul class="h-64 flex-1 divide-y divide-gray-medium overflow-y-auto">
                @foreach ($results as $result)
                    <li><a class="block py-6 hover:bg-gray-dark"
                            href="{{ route('event.show', ['event' => $result->slug]) }}">{{ $result->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
