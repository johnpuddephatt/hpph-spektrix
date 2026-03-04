<a target="_blank" href="{{ $link }}"
    class="not-prose relative my-16 block max-w-lg rounded bg-sand-dark !no-underline transition hover:bg-opacity-70">
    <div class="p-6 pl-[10%]">
        <div
            class="type-xs-mono absolute right-full origin-right translate-x-6 -rotate-90 transform whitespace-nowrap font-normal">
            Link</div>
        <div class="">

            @if ($meta['imageUrl'] ?? null)
                <img class="mb-2 w-64 rounded" src="{{ $meta['imageUrl'] }}" />
            @endif

            <div class="">
                <h2 class="type-lg mb-3 mt-3">{{ $meta['title'] }}</h2>
                <div class="type-sm">
                    {{ \Illuminate\Support\Str::limit($meta['description'], 160) }}
                </div>
            </div>
        </div>
    </div>
</a>
