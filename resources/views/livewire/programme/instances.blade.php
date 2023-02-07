<div class="">
    <x-instances :instances="$instances" :options="$options" :dark="$dark" />

    @if ($show_load_more)
        <button class="text-left" wire:click="$set('page', {{ $page + 1 }})">
            <h3 class="tracking-tight font-bold">Load more</h3>
            <div class="mt-2 w-12 rounded-full bg-yellow text-black">
                @svg('chevron-right', 'w-full h-auto p-0.5')
            </div>
        </button>
    @endif
</div>
