<div class="grid lg:grid-cols-2">
    @if ($layout->image)
        <img src="{{ Storage::disk('public')->url($layout->image) }}" class="w-full h-auto" />
    @endif
    @if ($layout->image_2)
        <img src="{{ Storage::disk('public')->url($layout->image_2) }}" class="w-full h-auto" />
    @endif

</div>