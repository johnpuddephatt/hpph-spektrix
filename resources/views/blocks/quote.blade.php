    <div class="@if ($dark) bg-black @endif flex flex-col lg:flex-row">
        <div style="background-color: @yield('color')"
            class="py-24 lg:py-8 flex items-center text-center flex-col justify-center bg-yellow lg:w-1/2">
            <div class="container">
                <div class="text-center lg:hidden text-6xl mb-2 leading-none">&OpenCurlyDoubleQuote;</div>
                <h2 class="type-regular lg:type-medium max-w-lg mx-auto mb-12 lg:mb-16">“{{ $layout->quote }}”</h2>
                <p class="type-xs-mono mx-auto max-w-md">{{ $layout->name }}</p>
                <p class="type-xs-mono mx-auto max-w-md">{{ $layout->role }}</p>
            </div>
        </div>
        <div class="w-full lg:w-1/2 bg-black-light">
            <img src="{{ Storage::url($layout->image) }}"
                class="aspect-[4/3] object-cover lg:aspect-auto block max-w-none w-full" />
        </div>

    </div>
