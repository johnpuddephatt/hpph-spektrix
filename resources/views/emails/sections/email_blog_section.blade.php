@php
$post = \App\Models\Post::withoutGlobalScopes()->find($section->post);
@endphp

@if ($post)
    {{-- prettier-ignore-start --}}
<mj-wrapper background-color="#ffda3d" full-width="full-width">
<mj-section padding="25px 0">
<mj-column padding="0 10px" css-class="hpph-pick">
 <mj-hero full-width="full-width" css-class="film-column-hero" border-radius="5px" vertical-align="middle"
        mode="fluid-height" background-width="1200px" background-height="720px"
        background-url="{{ $post->featuredImage?->getUrl('landscape')  }}"
        background-color="#2a3448" padding="0px 0px">

    </mj-hero>
</mj-column>
<mj-column padding="0 10px">
                <mj-text line-height="1.2" padding="5px 0 5px 0" font-weight="700" font-size="24px">
{{ $post->title }}
</mj-text>
<mj-text padding="0 0 0px 0">{!! $post->introduction !!}</mj-text>
<mj-button padding="10px 0 0 0" inner-padding="5px 10px" font-weight="bold" width="100%" padding="0"
background-color="#000000" color="#ffda3d" href="{{ $post->url }}">Read more
</mj-button>
</mj-column>
</mj-section>
</mj-wrapper>
@endif
{{-- prettier-ignore-end --}}