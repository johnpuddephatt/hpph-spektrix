<blockquote
    class="{{ $blockwidth == '' ? 'max-w-[50ch]' : '' }} {{ $blockwidth == 'wide' ? 'lg:container lg:!mr-0 lg:w-2/3' : '' }} {{ $blockwidth == 'full' ? 'lg:container lg:ml-[calc(25vw)] lg:text-right lg:w-[75vw] lg:max-w-[calc(55ch+25vw+3rem)]' : '' }} relative my-16 lg:my-24">
    <p class="{{ $blockwidth == 'full' ? 'lg:type-large' : 'lg:type-medium' }} type-regular lg:-indent-3">
        “{{ $text }}”
    </p>
    @if ($caption)
        <cite class="type-xs-mono mt-12 block not-italic">{!! $caption !!}</cite>
    @endif
</blockquote>
