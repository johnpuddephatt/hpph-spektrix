<div class="ml-auto" x-data="{ open: false }">
    <button class="relative z-40 rounded py-1 px-2" :class="open ? 'bg-yellow text-black' : ''"
        @click="open = !open; $nextTick(() => $refs.searchInput.focus());">Search</button>

    <div @click.self="open = ! open" x-show="open" x-transition:enter-start="opacity-0" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-30 bg-black bg-opacity-80 duration-300">
    </div>
    <div class="container fixed inset-0 left-auto z-30 flex h-screen w-full max-w-md transform flex-col border-t-[5em] border-black bg-black text-white transition-all delay-100 duration-200"
        x-show="open" x-transition:enter-start="translate-x-full" x-transition:leave-end="translate-x-full">

        <input x-ref="searchInput"
            class="type-annotation bg-transparent w-full border-b-2 border-white py-6 text-3xl focus-visible:outline-none"
            wire:model="search" type="text" placeholder="Search for a film" />

        <ul class="h-64 flex-1 divide-y divide-gray-medium overflow-y-auto">
            @foreach ($results as $result)
                <li><a class="block py-6 hover:bg-gray-dark"
                        href="{{ route('event.show', ['event' => $result->slug]) }}">{{ $result->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
