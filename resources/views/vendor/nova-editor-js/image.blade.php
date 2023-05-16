@php
if (!isset($width)) {
    $width = '';
}
@endphp
<figure class="{{ $width == '' ? 'max-w-[50ch]' : '' }} my-16 relative">
    <img loading="lazy" class="@if ($width != 'full') rounded @endif w-full" src="{{ $file['url'] }}"
        alt="{{ $caption }}">
    @if (!empty($caption))
        <figcaption
            class="type-xs-mono @if ($width !== 'full') xl:transform xl:absolute xl:-left-2 xl:max-w-xs xl:bottom-0 xl:-rotate-90 xl:origin-bottom-left @else container lg:w-1/2 lg:mr-0 mx-auto @endif mt-3">
            {{ $caption }}</figcaption>
    @endif
</figure>
