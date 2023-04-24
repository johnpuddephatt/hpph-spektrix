    <div class="@if ($dark) bg-black @endif flex flex-col lg:flex-row">
        <div style="background-color: @yield('color')"
            class="py-8 flex items-center text-center flex-col justify-center bg-yellow lg:w-1/2">
            <h2 class="type-medium max-w-lg mx-auto mb-6 lg:mb-16">“{{ $layout->quote }}”</h2>
            <p class="type-xs-mono mx-auto max-w-md">{{ $layout->name }}</p>
            <p class="type-xs-mono mx-auto max-w-md">{{ $layout->role }}</p>
        </div>
        <div class="w-full lg:w-1/2 bg-black-light">
            <img src="{{ Storage::url($layout->image) }}" class="block max-w-none w-full" />
        </div>

    </div>
