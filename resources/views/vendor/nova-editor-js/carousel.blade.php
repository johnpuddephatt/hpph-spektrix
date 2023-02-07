@php
$width = isset($_tunes) ? ($_tunes->blockWidthTune ?: 'normal') : 'normal';
@endphp

<div class="@if ($width !== 'full') container max-w-6xl @endif relative my-16">

    <div
        class="ml-[calc((100vw-100%)/-2)] flex w-screen flex-row gap-5 overflow-x-auto px-[calc((100vw-100%)/2)] pb-6 scrollbar-hide">
        @foreach ($images as $image)
            <figure class="flex-none">
                <img src="{{ $image->url }}" class="block h-[32em] w-auto rounded">

                <figcaption class="type-xs-mono py-3">
                    @if (count($images) > 1)
                        <strong>{{ $loop->iteration }}/{{ count($images) }}</strong>
                    @endif
                    @if (isset($image->caption))
                        {{ $image->caption }}
                    @endif
                </figcaption>
            </figure>
        @endforeach
    </div>

</div>
