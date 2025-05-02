    <div class="@if ($width !== 'full' && $width !== 'wide') max-w-2xl @endif relative mt-8 mb-12 aspect-video">
        <iframe  frameborder="0"
            class="@if ($width !== 'full') rounded @endif absolute inset-0 h-full w-full" allowfullscreen=""
            src="{{ $embed }}"></iframe>
            @if($caption    )
        <div class="caption">
            {{ $caption }}
        </div>
        @endif
    </div>
