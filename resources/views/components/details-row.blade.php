@if ($value)
    <div class="flex flex-row gap-4 py-4">
        <div class="w-56 font-bold">{{ $label }}</div>
        <div class="flex-1">{!! $value !!}</div>
    </div>
@endif
