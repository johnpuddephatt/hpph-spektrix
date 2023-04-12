<a target="_blank" href="{{ $link }}"
    class="bg-sand-dark !no-underline hover:bg-opacity-70 transition block rounded max-w-lg my-16 relative">
    <div class="p-6 pl-[10%]">
        <div class="type-xs-mono absolute right-full origin-right translate-x-6 -rotate-90 transform whitespace-nowrap">
            Link</div>
        <div class="">

            @if ($meta['imageUrl'])
                <img class="w-64 rounded mb-2" src="{{ $meta['imageUrl'] }}" />
            @endif

            <div class="">
                <h2 class="type-regular mb-3 mt-3">{{ $meta['title'] }}</h2>
                <div class="type-xs-mono">
                    {{ \Illuminate\Support\Str::limit($meta['description'], 100) }}
                </div>
            </div>
        </div>
    </div>
</a>
