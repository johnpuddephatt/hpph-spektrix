<div class="grid lg:grid-cols-2">
    @if ($layout->image)
        <figure>
            <img src="{{ Storage::url($layout->image) }}" class="w-full h-auto" />
            @if ($layout->caption)
                <figcaption class="type-xs-mono mt-3">{{ $layout->caption }}</figcaption>
            @endif
        </figure>
    @endif
    @if ($layout->image_2)
        <figure>
            <img src="{{ Storage::url($layout->image_2) }}" class="w-full h-auto" />
            @if ($layout->caption_2)
                <figcaption class="type-xs-mono mt-3">{{ $layout->caption_2 }}</figcaption>
            @endif
        </figure>
    @endif

</div>
