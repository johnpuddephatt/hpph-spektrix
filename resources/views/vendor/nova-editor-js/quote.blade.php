<blockquote
    class="{{ $width == '' ? 'max-w-[50ch]' : '' }} {{ $width == 'wide' ? 'lg:container lg:!mr-0 lg:w-2/3' : '' }} {{ $width == 'full' ? 'lg:container lg:ml-[calc(25vw)] lg:text-right lg:w-[75vw] lg:max-w-[calc(55ch+25vw+3rem)]' : '' }} my-16 lg:my-24 relative">
    <p class="{{ $width == 'full' ? 'lg:type-large' : '' }} type-medium lg:-indent-3">
        “{{ $text }}”
    </p>
    @if ($caption)
        <cite class="type-xs-mono mt-12 block not-italic">{!! $caption !!}</cite>
    @endif
</blockquote>
