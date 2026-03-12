@if ($layout->image)
    <figure>
        <img src="{{ Storage::url($layout->image) }}"
            class="{{ $layout->short_height ? 'lg:aspect-[3] object-cover' : '' }} h-auto w-full" />
        @if ($layout->caption)
            <figcaption class="type-xs-mono mt-3">{{ $layout->caption }}</figcaption>
        @endif
    </figure>
@endif
