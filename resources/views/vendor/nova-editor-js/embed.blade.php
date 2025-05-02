@php
if (!isset($blockwidth)) {
    $blockwidth = '';
}
@endphp
<div style="padding-top: {{ $height/$width * 100}}%" class="@if ($blockwidth !== 'full' && $blockwidth !== 'wide') max-w-2xl @endif relative mt-8 mb-12 ">
    <iframe  frameborder="0"
        class="@if ($blockwidth !== 'full') rounded @endif absolute inset-0 h-full w-full" allowfullscreen=""
        src="{{ $embed }}"></iframe>
    @if($caption)
        <div class="caption">
            {{ $caption }}
        </div>
    @endif
</div>
