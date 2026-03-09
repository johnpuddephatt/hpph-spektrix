<a href="{{ $layout->url }}" class="block border-t-2 border-yellow-dark bg-yellow py-4 transition hover:bg-yellow-dark">
    <div class="container flex flex-row items-center gap-4">
        <div class="lg:w-1/2">
            @svg('plus', 'h-6 w-6')
        </div>
        <div>
            <h3 class="type-small lg:type-regular">
                {{ $layout->title }}
            </h3>

            @if ($layout->subtitle)
                <p class="">
                    {{ $layout->subtitle }}
                </p>
            @endif

        </div> @svg('arrow-right', 'ml-auto h-8 w-8 p-2 text-yellow bg-black rounded-full')

    </div>
</a>
