<div class="grid lg:grid-cols-2">
    @if ($layout->image)
        <x-image class="w-full h-auto" width="100vw" :src="Storage::url($layout->image)" />
    @endif
    @if ($layout->image_2)
        <x-image class="w-full h-auto" width="100vw" :src="Storage::url($layout->image_2)" />
    @endif

</div>
