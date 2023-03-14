@if ($layout->features)
    <div class="bg-black text-white pt-8 pb-16">
        <div class="container flex flex-col lg:flex-row justify-center gap-4">
            @foreach ($layout->features as $feature)
                <div class="w-1/3">
                    <img class="rounded w-full" src="{{ Storage::url($feature->image) }}" />
                    <h3 class="type-regular mt-8 mb-6 flex items-center">@svg('tick', 'h-6 w-6 p-1 mr-2 rounded-full bg-yellow text-black inline-block') {{ $feature->title }}</h3>
                    <p class="max-w-md">{{ $feature->description }}
                    <p>
                </div>
            @endforeach
        </div>
    </div>
@endif
