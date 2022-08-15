<div class="mr-auto" x-data="{ open: false }">

    <div @click.self="open = ! open; $dispatch('menutoggled', open)" x-show="open" x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 bg-black bg-opacity-80 duration-500">
    </div>

    <div class="container fixed inset-0 right-auto z-10 h-screen w-full max-w-lg transform space-y-16 overflow-y-auto border-t-[7em] border-black bg-black pb-24 text-white transition-all delay-100 duration-200"
        x-show="open" x-transition:enter-start="-translate-x-16 opacity-0"
        x-transition:leave-end="-translate-x-16 opacity-0">

        @foreach (\App\Models\Strand::all() as $strand)
            <div class="text-center">
                <div class="h-36 rounded bg-white opacity-50"></div>
                <div class="relative z-10 -mt-12 h-12 bg-gradient-to-t from-black"></div>
                <h3
                    class="relative z-20 -mt-10 inline-block break-all rounded-full border-2 border-yellow py-8 px-8 text-xl font-bold uppercase leading-none tracking-tight text-yellow">
                    {{ $strand->name }}</h3>
                <p class="mx-auto mt-8 max-w-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias
                    labore
                    reiciendis
                    consequatur.</p>
                <hr class="my-8 border-t-2 border-yellow" />
                <a class="type-label rounded bg-yellow py-2 px-12 text-black" href="#">Explore</a>
            </div>
        @endforeach
    </div>

    <button class="relative rounded py-1 px-2" :class="open ? 'bg-yellow text-black z-40' : 'z-20'"
        @click="open = ! open; $dispatch('menutoggled', open)">{{ $slot }}</button>

</div>
