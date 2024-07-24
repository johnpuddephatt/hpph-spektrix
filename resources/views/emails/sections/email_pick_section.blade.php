@php

$pick = \App\Models\Post::withoutGlobalScopes()->find($section->pick);
@endphp
<mj-wrapper background-color="#f8f7ef" full-width="full-width">

    <mj-section padding="25px 5px">
        <mj-column>
            <mj-hero border-radius="5px" vertical-align="middle" mode="fluid-height" background-width="1200px"
                background-height="720px" background-url="{{ $pick->featuredImage?->getUrl('landscape') }}"
                background-color="#2a3448" padding="0px 0px">

                <mj-text padding="10px" color="#ffda3d" align="center" font-size="30px" line-height="30px"
                    letter-spacing="10px" font-weight="600">
                    HYDE PARK PICK</mj-text>

            </mj-hero>

        </mj-column>
        <mj-column>
            <mj-text font-size="24px" line-height="1.1" font-weight="700" padding="10px 0 10px 15px">
                {{ $pick->title }}
            </mj-text>
            <mj-text padding="0 0 0px 15px">{!! $pick->introduction !!}</mj-text>
            <mj-button padding="10px 0 0 15px" inner-padding="5px 10px" font-weight="bold" width="100%" padding="0"
                background-color="#ffda3d" color="#000000" href="{{ $pick->url }}">Read more
            </mj-button>
        </mj-column>
    </mj-section>
</mj-wrapper>
