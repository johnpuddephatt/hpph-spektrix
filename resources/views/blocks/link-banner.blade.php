<a href="{{ $layout->url }}" class="bg-yellow transition hover:bg-gray-medium hover:text-yellow block py-4">
    <div class="container flex flex-row items-center">
        <div class="w-1/2">
            @svg('plus', 'h-6 w-6')
        </div>
        <div class="type-regular">
            {{ $layout->title }}

        </div> @svg('arrow-right', 'ml-auto h-8 w-8 p-2 text-yellow bg-black rounded-full')

    </div>
</a>
