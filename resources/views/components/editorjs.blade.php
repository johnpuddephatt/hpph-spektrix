@props(['content', 'block_class' => 'max-w-3xl mx-auto', 'width' => null, 'wide_class' => 'max-w-6xl mx-auto', 'fullwidth_class' => ''])

@if (isset($block))
    @php $content = $block->editorjs @endphp
@endif

<div {{ $attributes->class(['']) }}>
    @foreach ($content->blocks as $block)
        @php $block = (array) $block @endphp
        @php $width = $block['tunes']['blockWidthTune'] ?? ''; @endphp

        @if ($block['type'] == 'carousel')
            @php $block['data']['images'] = $block['data'] @endphp
        @endif

        <div
            class="@if ($width == 'full') {{ $fullwidth_class }} @elseif($width == 'wide') {{ $wide_class }} @else {{ $block_class }} @endif">

            @include('vendor.nova-editor-js.' . $block['type'],
                array_merge((array) $block['data'], ['width' => $width]))

        </div>
    @endforeach
</div>
