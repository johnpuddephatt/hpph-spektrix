{{-- Outer wrapper <div> needed for LiveWire --}}

<div class="bg-sand">
    <div class="container pt-36 pb-6 flex flex-row items-end justify-between">

        <h1 class="type-medium lg:type-large">
            Shop
        </h1>

        </p>
    </div>

    <div class="flex flex-col lg:block">
        <div
            class="bg-sand-light z-10 sticky bottom-0 lg:static lg:bottom-auto lg:container lg:flex flex-row justify-between border-b border-sand lg:py-2.5">

            <div class="grid grid-cols-3 px-4 py-3 lg:p-0 lg:flex flex-row items-center gap-4 lg:gap-2.5">
                <div class="type-xs-mono hidden lg:block">Filter:</div>
                <button
                    class="type-xs-mono {{ !$selected_type ? 'bg-yellow ' : 'hover:bg-sand-dark bg-sand' }} cursor-default rounded pt-2 py-1.5 px-3"
                    wire:click="$emit('updateType', '')">All</button>
                @foreach ($types as $type)
                    <button
                        class="type-xs-mono {{ $selected_type == $type ? 'bg-yellow ' : 'hover:bg-sand-dark bg-sand' }} cursor-default rounded pt-2 py-1.5 px-3"
                        wire:click="$emit('updateType', '{{ $type }}')">{{ $type }}</button>
                @endforeach
            </div>
        </div>

        <div class="-order-1 py-16">
            <div class="container grid lg:grid-cols-3 gap-8">
                @foreach ($products as $product)
                    <a class="group block" href="{{ $product->url }}">
                        {!! $product->featuredImage->img('landscape')->attributes(['class' => 'rounded w-full block']) !!}
                        <div class="mt-4 flex flex-row justify-between items-start gap-2">
                            <div>
                                <h3 class="type-regular mb-2">{{ $product->name }}</h3>
                                <p class="type-regular !font-normal">{{ $product->price }}</p>
                            </div>
                            <div class="p-3 rounded bg-sand-light group-hover:bg-yellow transition">
                                @svg('arrow-right', '-rotate-45 h-5 w-5')
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>