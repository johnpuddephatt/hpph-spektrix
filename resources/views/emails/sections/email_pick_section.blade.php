@php
$pick = \App\Models\Post::withoutGlobalScopes()->find($section->pick);
@endphp

@if ($pick)
    {{-- prettier-ignore-start --}}
<mj-wrapper background-color="#ffda3d" full-width="full-width">
<mj-section padding="25px 0">


<mj-column padding="0 10px" css-class="hpph-pick">





 <mj-hero full-width="full-width" css-class="film-column-hero" border-radius="5px" vertical-align="middle"
        mode="fluid-height" background-width="800px" background-height="800px"
        background-url="{{ $pick->featuredImage?->getUrl('square')  }}"
        background-color="#2a3448" padding="0px 0px">
        <mj-text padding="10px" color="#ffda3d" align="center" font-size="30px" line-height="30px"
letter-spacing="10px" font-weight="600">
HYDE PARK PICK</mj-text>


    </mj-hero>
</mj-column>
<mj-column padding="0 10px">

<x-email.heading type="xs-mono" padding="5px 0 10px 0">This week’s Hyde Park Pick</x-email.heading>

<x-email.heading type="medium" padding="5px 0 10px 0">
{{ Str::of($pick->title)->replace('Hyde Park Pick… ', '')->replace('Hyde Park Pick: ', '') }}
</x-email.heading>

<mj-text padding="0 0 0px 0">{!! $pick->introduction !!}</mj-text>
<mj-button padding="15px 0 0 0" inner-padding="5px 10px" font-weight="bold" width="100%" padding="0"
background-color="#ffffff" color="#000000" href="{{ $pick->url }}">Read more
</mj-button>
</mj-column>
</mj-section>
</mj-wrapper>
{{-- prettier-ignore-end --}}
@endif
