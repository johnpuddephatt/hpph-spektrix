    <div class="@if ($dark) bg-black @endif flex flex-col lg:flex-row">
        <div style="background-color: @yield('color')"
            class="flex flex-col items-center justify-center bg-yellow py-24 text-center lg:w-1/2 lg:py-8">
            <div class="container">
                <div class="mb-2 text-center text-6xl leading-none lg:hidden">&OpenCurlyDoubleQuote;</div>
                <h2 class="type-regular lg:type-medium mx-auto mb-12 max-w-lg lg:mb-16">“{{ $layout->quote }}”</h2>
                <p class="type-xs-mono mx-auto max-w-md">{{ $layout->name }}</p>
                <p class="type-xs-mono mx-auto max-w-md">{{ $layout->role }}</p>
            </div>
        </div>
        <div class="w-full bg-black-light lg:w-1/2">
            <img src="{{ Storage::url($layout->image) }}"
                class="block aspect-[3/2] w-full max-w-none object-cover lg:aspect-auto" />
        </div>

    </div>
