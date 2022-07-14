<div x-data="{ open: false }">
    <button @click="open = true; $nextTick(() => $refs.searchInput.focus());">Search</button>

    <div x-cloak x-show="open" class="fixed inset-0 z-30 flex items-center justify-center bg-black bg-opacity-90">

        <div class="w-full max-w-md" @click.outside="open = false">
            <input x-ref="searchInput" class="mb-8 w-full rounded-full p-4 text-lg text-black" wire:model="search"
                type="text" placeholder="Search for a film" />

            <ul class="h-64 overflow-y-auto">
                @foreach ($results as $result)
                    <li class="py-3 text-white"><a
                            href="{{ route('event.show', ['film' => $result->slug]) }}">{{ $result->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
