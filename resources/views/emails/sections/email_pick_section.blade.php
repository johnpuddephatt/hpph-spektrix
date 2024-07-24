@php
$pick = \App\Models\Post::withoutGlobalScopes()->find($section->pick);
@endphp
{{-- prettier-ignore-start --}}
<mj-wrapper background-color="#f8f7ef" full-width="full-width">
<mj-section padding="25px 0">


<mj-column padding="0 10px" css-class="hpph-pick">

        <mj-image  border-radius="5px"  fluid-on-mobile="true"	 padding="0"   src="{{ $pick->featuredImage?->getUrl('landscape') }}" />

<mj-text padding="10px" color="#ffda3d" align="center" font-size="30px" line-height="30px"
letter-spacing="10px" font-weight="600">
HYDE PARK PICK</mj-text>



</mj-column>
<mj-column padding="0 10px">
<mj-text font-size="24px" line-height="1.1" font-weight="700" padding="5px 0 10px 0px">
{{ $pick->title }}
</mj-text>
<mj-text padding="0 0 0px 0">{!! $pick->introduction !!}</mj-text>
<mj-button padding="10px 0 0 0" inner-padding="5px 10px" font-weight="bold" width="100%" padding="0"
background-color="#ffda3d" color="#000000" href="{{ $pick->url }}">Read more
</mj-button>
</mj-column>
</mj-section>
</mj-wrapper>
{{-- prettier-ignore-end --}}
