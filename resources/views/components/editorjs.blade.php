@if (isset($block))
    @php $content = $block->editorjs @endphp
@endif

<div class="{{ $align ?? null == 'right' ? 'ml-[50%] max-w-xl' : '' }} py-20">
    @foreach ($content->blocks as $block)
        @if ($block->type == 'carousel')
            @php $block->data = ['images' => $block->data] @endphp
        @endif
        @include('vendor.nova-editor-js.' . $block->type,
            array_merge((array) $block->data, ['_tunes' => $block->tunes ?? []]))
    @endforeach
</div>
