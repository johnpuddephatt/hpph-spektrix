@foreach ($films as $film)
    <mj-section padding="25px 0px 5px">
        <mj-column width="30%">

            <mj-hero border-radius="5px" vertical-align="bottom" mode="fluid-height" background-width="1200px"
                background-height="720px"
                background-url="{{ $film->featuredImage?->getUrl('wide') ?? 'https://cloud.githubusercontent.com/assets/1830348/15354890/1442159a-1cf0-11e6-92b1-b861dadf1750.jpg' }}"
                background-color="#2a3448" padding="0px 0px">
                @if ($film->strand && $film->strand->name !== 'Bring Your Own Baby')
                    <mj-button color="#000000" background-color="{{ $film->strand->color }}" width="100%"
                        line-height="1" padding="0px" font-size="11px" font-weight="bold" inner-padding="4px 0"
                        align="center">

                        {{ strtoupper($film->strand->name) }}
                    </mj-button>
                @endif
            </mj-hero>

        </mj-column>
        <mj-column width="70%">
            <mj-text line-height="1.2" padding="5px 0 5px 15px" font-weight="700" font-size="18px">
                {{ $film->name }}
                @if ($film->certificate_age_guidance)
                    <span
                        style="line-height: 1.1; vertical-align: middle; border-radius: 100px; background-color: #333; color: white; padding: 1px 4px 0; font-weight: 400; font-size: 10px; display: inline-block">{{ $film->certificate_age_guidance }}</span>
                @endif
            </mj-text>
            <mj-text padding="0 0 0px 15px">{!! $film->description !!}</mj-text>

        </mj-column>
    </mj-section>
    <mj-section @if (!$loop->last) border-bottom="1px solid #b5b5b5" @endif padding="0 0px 20px">
        <mj-column width="30%"></mj-column>
        <mj-column width="35%">
            @if ($film->instances->count() > 2)
                <mj-accordion>
                    <mj-accordion-element>
                        <mj-accordion-title>Toggle {{ $film->instances->count() }} showings</mj-accordion-title>
                        <mj-accordion-text>
                            @include('emails.components.instance_times')
                        </mj-accordion-text>
                    </mj-accordion-element>

                </mj-accordion>
            @else
                @include('emails.components.instance_times')
            @endif
        </mj-column>
        <mj-column width="35%">
            <mj-button inner-padding="5px 10px" font-weight="bold" width="100%" padding="0px 0px 0px 15px"
                background-color="#ffda3d" color="#000000" href="{{ $film->url }}">More
                info &amp; tickets
            </mj-button>
        </mj-column>

    </mj-section>
@endforeach
