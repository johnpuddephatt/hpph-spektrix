@if ($layout->image)
    <img src="{{ Storage::disk('public')->url($layout->image) }}" class="w-full h-auto" />
@endif
