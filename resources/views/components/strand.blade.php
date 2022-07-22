@if ($strand)
    <div class="group relative w-6 text-gray" style="color: {{ $strand->color }}">
        <div style="background-color: currentColor;" class="h-6 w-6 rounded-full"></div>
        <div class="type-annotation absolute left-1/2 top-full translate-y-2 -translate-x-1/2 transform whitespace-nowrap rounded py-1 px-3 opacity-0 transition duration-500 group-hover:opacity-100"
            style="background-color: currentColor;">
            <div class="absolute left-1/2 bottom-full h-4 w-4 -translate-x-1/2 transform border-8 border-transparent border-b-gray"
                style="border-bottom-color: currentColor;">
            </div>

            <span class="text-black">{{ $strand->name }}</span>

        </div>
    </div>
@endif
