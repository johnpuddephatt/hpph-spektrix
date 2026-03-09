<a href="{{ $layout->url }}" class="block border-t-2 border-yellow-dark bg-yellow py-4 transition hover:bg-yellow-dark">
    <div class="container flex flex-row items-start">
        <div class="flex-none pr-4 lg:w-1/2">
            @svg('plus', 'h-6 w-6')
        </div>
        <div>
            <h3 class="type-small lg:type-regular">
                {{ $layout->title }}
            </h3>

            @if ($layout->subtitle)
                <p class="mt-4 leading-tight">
                    {{ $layout->subtitle }}
                </p>
            @endif

        </div> @svg('arrow-right', 'flex-none ml-auto h-8 w-8 ml-4 p-2 text-yellow bg-black rounded-full')

    </div>
</a>
