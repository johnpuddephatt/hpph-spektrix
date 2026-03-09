<a href="{{ $layout->url }}" class="block border-t-2 border-yellow-dark bg-yellow py-4 transition hover:bg-yellow-dark">
    <div class="container flex flex-row items-center gap-4">
        <div class="lg:w-1/2">
            @svg('plus', 'h-6 w-6')
        </div>
        <div class="type-regular">
            {{ $layout->title }}

        </div> @svg('arrow-right', 'ml-auto h-8 w-8 p-2 text-yellow bg-black rounded-full')

    </div>
</a>
