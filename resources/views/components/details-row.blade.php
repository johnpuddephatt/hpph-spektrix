@if ($value)
    <div class="lg:flex lg:flex-row lg:gap-4 py-4">
        <div class="w-56 font-bold">{{ $label }}</div>
        <div class="flex-1">{!! $value !!}</div>
    </div>
@endif
