<div>
    @if ($show_header && count($options ?? []))
        <h2 class="type-h4 mb-16 font-bold">Showing

            @foreach ($options as $option)
                <button
                    class="type-h4 {{ $selected_option == $loop->index && count($options) > 1 ? 'text-yellow underline' : '' }} font-bold lowercase"
                    wire:click="$set('selected_option', {{ $loop->index }})">{{ $option['label'] }}</button>
                @if (!$loop->last)
                    /
                @endif
            @endforeach
        </h2>
    @endif

    @include('components.instances')

    @if ($show_load_more)
        <button class="text-left" wire:click="$set('page', {{ $page + 1 }})">
            <h3 class="font-bold tracking-tight">Load more</h3>
            <span class="mt-2 inline-block h-14 w-14 rounded-full bg-yellow"></span>
        </button>
    @endif
</div>
