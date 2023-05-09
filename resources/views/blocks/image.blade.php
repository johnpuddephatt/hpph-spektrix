@if ($layout->image)
    <figure>
        <img src="{{ Storage::url($layout->image) }}" class="w-full h-auto" />
        @if ($layout->caption)
            <figcaption class="type-xs-mono mt-3">{{ $layout->caption }}</figcaption>
        @endif
    </figure>
@endif
