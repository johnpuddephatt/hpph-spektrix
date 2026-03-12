<div class="grid lg:grid-cols-2">
    @if ($layout->image)
        <figure>
            <img src="{{ Storage::url($layout->image) }}"
                class="{{ $layout->short_height ? 'lg:aspect-[1.5] object-cover' : '' }} h-auto w-full" />
            @if ($layout->caption)
                <figcaption class="type-xs-mono mt-3">{{ $layout->caption }}</figcaption>
            @endif
        </figure>
    @endif
    @if ($layout->image_2)
        <figure>
            <img src="{{ Storage::url($layout->image_2) }}"
                class="{{ $layout->short_height ? 'lg:aspect-[1.5] object-cover' : '' }} h-auto w-full" />
            @if ($layout->caption_2)
                <figcaption class="type-xs-mono mt-3">{{ $layout->caption_2 }}</figcaption>
            @endif
        </figure>
    @endif

</div>
