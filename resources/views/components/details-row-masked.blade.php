@if ($value)
    <div x-cloak x-data="{ show: false }" class="lg:flex lg:flex-row lg:gap-4 py-4">
        <div class="w-56 font-bold">{{ $label }}</div>
        <button
            class="type-xs-mono border-sand-dark lg:-mt-1 lg:-ml-4 inline-block uppercase border-2 px-4 py-2 rounded hover:bg-sand-dark transition"
            @click="show = true" x-show="!show">Show {{ $label }}</button>
        <div x-show="show" class="flex-1">{!! $value !!}</div>
    </div>
@endif
