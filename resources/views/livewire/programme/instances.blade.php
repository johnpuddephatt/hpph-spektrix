<div>
    @if ($show_header && count($options ?? []))
        <h2 class="type-subtitle lg:type-h5 mb-16 font-bold">Showing

            @foreach ($options as $option)
                <button
                    class="type-subtitle lg:type-h5 {{ $selected_option == $loop->index && count($options) > 1 ? 'text-yellow underline' : '' }} font-bold lowercase"
                    wire:click="$set('selected_option', {{ $loop->index }})">{{ $option['label'] }}</button>
                @if (!$loop->last)
                    /
                @endif
            @endforeach
        </h2>
    @endif

    <x-instances :instances="$instances" :options="$options" :dark="$dark" :selected_option="$selected_option" />

    @if ($show_load_more)
        <button class="text-left" wire:click="$set('page', {{ $page + 1 }})">
            <h3 class="tracking-tight font-bold">Load more</h3>
            <div class="mt-2 w-12 rounded-full bg-yellow text-black">
                @svg('right-chevron', 'w-full h-auto p-0.5')
            </div>
        </button>
    @endif
</div>
