@if ($layout->image)
    <x-image class="w-full h-auto" width="100vw" :src="Storage::disk('public')->url($layout->image)" />
@endif
