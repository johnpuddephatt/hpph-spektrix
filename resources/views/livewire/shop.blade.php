{{-- Outer wrapper <div> needed for LiveWire --}}

<div class="bg-sand">
    <div class="container flex flex-row items-end justify-between pb-6 pt-36">

        <h1 class="type-medium lg:type-large">
            Shop
        </h1>

        </p>
    </div>

    <div class="flex flex-col md:block">
        <div
            class="sticky bottom-0 z-10 flex-row justify-between border-b border-sand bg-sand-light md:container md:static md:bottom-auto md:flex md:py-2.5">

            <div class="flex flex-row items-center gap-2 px-4 py-3 md:gap-2.5 md:p-0">
                <div class="type-xs-mono hidden md:block">Filter:</div>
                <button
                    class="type-xs-mono {{ !$selected_type ? 'bg-yellow ' : 'hover:bg-sand-dark bg-sand' }} flex-grow cursor-default rounded px-3 py-1.5 pt-2"
                    wire:click="$dispatch('updateType', { value: '' })">All</button>
                @foreach ($types as $type)
                    <button
                        class="type-xs-mono {{ $selected_type == $type ? 'bg-yellow ' : 'hover:bg-sand-dark bg-sand' }} flex-grow cursor-default rounded px-3 py-1.5 pt-2"
                        wire:click="$dispatch('updateType', { value: '{{ $type }}' })">{{ $type }}</button>
                @endforeach
            </div>
        </div>

        <div class="-order-1 py-16">
            <div class="container grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($products as $product)
                    <a class="group block" href="{{ $product->url }}">
                        <div class="overflow-hidden">
                            {!! $product->featuredImage->img('landscape')->attributes(['class' => 'group-hover:scale-105 transition duration-500 rounded w-full block']) !!}
                        </div>
                        <div class="mt-4 flex flex-row items-start justify-between gap-2">
                            <div>
                                <h3 class="type-regular mb-2">{{ $product->name }}</h3>
                                <p class="type-regular !font-normal">{{ $product->price }}</p>
                            </div>
                            <div class="rounded bg-sand-light p-3 transition group-hover:bg-yellow">
                                @svg('arrow-right', 'h-5 w-5')
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
