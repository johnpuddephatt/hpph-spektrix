    <div class="py-16 bg-black flex flex-col lg:flex-row">
        <div class="bg-yellow" style="background-color: @yield('color')"
            class="flex items-center text-center flex-col justify-center bg-black lg:w-1/2">
            <h2 class="type-medium max-w-lg mx-auto mb-6 lg:mb-16">“{{ $layout->quote }}”</h2>
            <p class="type-xs-mono mx-auto max-w-md">{{ $layout->name }}</p>
            <p class="type-xs-mono mx-auto max-w-md">{{ $layout->role }}</p>
        </div>
        <div class="w-3/4 lg:w-1/2 bg-black-light">
            <img src="{{ Storage::url($layout->image) }}" class="block max-w-none w-full" />
        </div>

    </div>
