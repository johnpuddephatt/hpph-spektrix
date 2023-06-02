<div class="" x-data="{ open: false }">
    <button aria-label="Search for a film" title="Search for a film" class="relative block rounded"
        :class="{ 'bg-yellow text-black': open, 'max-lg:hidden': scrolled && !nav_open }"
        @click="open = !open; $nextTick(() => $refs.searchInput.focus()); $dispatch('menutoggled', open)">
        @svg('search', 'w-6 h-6 p-0.5')</button>

    <div @click.self="open = ! open; $dispatch('menutoggled', open)" x-show="open" x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-20 bg-black bg-opacity-60 duration-150 backdrop-blur-lg">

    </div>
    <div class="text-black container fixed inset-0 left-auto z-50 flex h-screen w-full max-w-lg transform flex-col bg-sand px-4 py-8 transition-all delay-100 duration-200"
        x-show="open" x-transition:enter-start="translate-x-full" x-transition:leave-end="translate-x-full">
        <div class="relative">
            <button class="absolute right-0 top-0 ml-auto" @click="open = ! open; $dispatch('menutoggled', open)"
                aria-label="Close search menu">@svg('plus', 'h-6 w-6 transform rotate-45 origin-center text-black')</button>
            <h2 class="type-medium mb-8">Search</h2>
            <input x-ref="searchInput"
                class="type-xs-mono w-full border-b-2 border-sand-dark bg-transparent py-6 focus-visible:outline-none"
                wire:model="search" type="text" placeholder="Search for a film" />

            <ul class="h-64 flex-1 divide-y divide-sand-dark overflow-y-auto">
                @foreach ($results as $result)
                    <li><a class="block py-6 hover:bg-sand-dark"
                            href="{{ route('event.show', ['event' => $result->slug]) }}">{{ $result->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
