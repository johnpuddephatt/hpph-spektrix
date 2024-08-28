@php
$pick = \App\Models\Post::withoutGlobalScopes()->find($section->pick);
@endphp

@if ($pick)
    {{-- prettier-ignore-start --}}
<mj-wrapper background-color="#f8f7ef" full-width="full-width">
<mj-section padding="25px 0">


<mj-column padding="0 10px" css-class="hpph-pick">





 <mj-hero full-width="full-width" css-class="film-column-hero" border-radius="5px" vertical-align="middle"
        mode="fluid-height" background-width="1200px" background-height="720px"
        background-url="{{ $pick->featuredImage?->getUrl('landscape')  }}"
        background-color="#2a3448" padding="0px 0px">
        <mj-text padding="10px" color="#ffda3d" align="center" font-size="30px" line-height="30px"
letter-spacing="10px" font-weight="600">
HYDE PARK PICK</mj-text>
    </mj-hero>
</mj-column>
<mj-column padding="0 10px">
                <mj-text line-height="1.2" padding="5px 0 5px 0" font-weight="700" font-size="24px">
{{ $pick->title }}
</mj-text>
<mj-text padding="0 0 0px 0">{!! $pick->introduction !!}</mj-text>
<mj-button padding="10px 0 0 0" inner-padding="5px 10px" font-weight="bold" width="100%" padding="0"
background-color="#000000" color="#ffda3d" href="{{ $pick->url }}">Read more
</mj-button>
</mj-column>
</mj-section>
</mj-wrapper>
{{-- prettier-ignore-end --}}
@endif
