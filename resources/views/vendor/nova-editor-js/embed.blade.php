    <div class="@if ($block_width ?? false == 'normal') max-w-2xl @endif relative my-16"
        style="padding-top: {{ ($height / $width) * 100 }}%">
        <iframe width="{{ $width }}px" height="{{ $height }}px" frameborder="0"
            class="@if ($width !== 'full') rounded @endif absolute inset-0 h-full w-full" allowfullscreen=""
            src="{{ $embed }}"></iframe>
        <div class="caption">
            {{ $caption }}
        </div>
    </div>
