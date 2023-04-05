<div class="{{ $width != 'full' ? '-mx-6' : '' }} overflow-hidden my-16 bg-sand-light px-6 pt-6 pb-0">
    <div
        class="ml-[calc((100vw-100%)/-2)] flex w-screen flex-row gap-5 overflow-x-auto px-[calc((100vw-100%)/2)] scrollbar-hide">
        @foreach ($images as $image)
            <figure
                class="@if (count($images) == 1) w-full @elseif (count($images) == 2) flex-none lg:flex-auto lg:w-auto relative lg:h-screen @else flex-none @endif">

                <img src="{{ $image['url'] }}"
                    class="@if (count($images) > 2) h-[32em] w-auto @elseif(count($images) == 2) max-w-[80vw] h-[100vw] lg:h-[calc(100%-3rem)] object-cover @else w-full h-auto @endif block rounded">

                <figcaption class="type-xs-mono py-3">

                    @if (isset($image['caption']))
                        {{ $image['caption'] }}
                    @endif
                </figcaption>
            </figure>
        @endforeach
    </div>
</div>
