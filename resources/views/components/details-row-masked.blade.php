@if ($value)
    <div x-cloak x-data="{ show: false }" class="flex flex-col lg:flex-row lg:gap-4 py-4">
        <div class="w-56 font-bold">{{ $label }}</div>
        <button
            class="type-xs-mono border-sand-dark -mt-1 -ml-4 inline-block uppercase border-2 px-4 py-2 rounded hover:bg-sand-dark transition"
            @click="show = true" x-show="!show">Show content guidance</button>
        <div x-show="show" class="flex-1">{!! $value !!}</div>
    </div>
@else
    <div class="flex flex-col lg:flex-row lg:gap-4 py-4">
        <div class="w-56 font-bold">{{ $label }}</div>
        <div class="flex-1">{!! $empty !!}</div>
    </div>
@endif
