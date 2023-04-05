<div class="{{ $width != 'full' ? '-mx-6' : '' }} overflow-hidden my-16 bg-sand-light px-4 lg:px-6 py-6">
    <div
        class="@if (count($images) < 3) lg:flex-row gap-4 lg:gap-5 flex-col @else flex-row gap-5 @endif ml-[calc((100vw-100%)/-2)] flex w-screen overflow-x-auto px-[calc((100vw-100%)/2)] scrollbar-hide">
        @foreach ($images as $image)
            <figure
                class="@if (count($images) < 3) w-full @elseif (count($images) == 2) w-full @else flex-none @endif">

                <img src="{{ $image['url'] }}"
                    class="@if (count($images) > 2) h-[24rem] lg:h-[32em] w-auto @elseif(count($images) == 2) w-full h-auto lg:max-w-[80vw] lg:h-full object-cover @else w-full h-auto @endif block rounded">

                @if ($image['caption'])
                    <figcaption class="type-xs-mono pt-4">

                        {{ $image['caption'] }}

                    </figcaption>
                @endif
            </figure>
        @endforeach
    </div>
</div>
