@foreach ($films->chunk($section->layout) as $chunk)
    <mj-section padding="50px 0px 0px">

        @foreach ($chunk as $film)
            <mj-column padding="0 {{ $loop->last ? 0 : '10px' }} 0 {{ !$loop->first ? '10px' : 0 }}"
                width="{{ 100 / $section->layout }}%">
                <mj-hero border-radius="5px" vertical-align="bottom" mode="fluid-height" background-width="1200px"
                    background-height="720px"
                    background-url="{{ $film->featuredImage?->getUrl('wide') ?? 'https://cloud.githubusercontent.com/assets/1830348/15354890/1442159a-1cf0-11e6-92b1-b861dadf1750.jpg' }}"
                    background-color="#2a3448" padding="0px 0px">
                    @if ($film->strand)
                        <mj-button color="#000000" background-color="{{ $film->strand->color }}" width="100%"
                            line-height="1" padding="0px" font-size="10px" font-weight="bold" inner-padding="4px 0"
                            align="center">

                            {{ strtoupper($film->strand->name) }}
                        </mj-button>
                    @endif
                </mj-hero>
                <mj-text line-height="1.2" padding="10px 0" font-family="BasisGrotesque" font-weight="700"
                    font-size="18px">
                    {{ $film->name }}&nbsp;@if ($film->certificate_age_guidance)
                        <span
                            style="line-height: 1.1; vertical-align: middle; border-radius: 100px; background-color: #333; color: white; padding: 1px 4px 0; font-weight: 400; font-size: 10px; display: inline-block">{{ $film->certificate_age_guidance }}</span>
                    @endif
                </mj-text>
                <mj-text padding="0 0 15px">{!! $film->description !!}</mj-text>
                <mj-text padding="0 0 15px  ">
                    Fri 14 Jun: 18:00 [talk]<br>
                    Sat 15 Jun: 11:45, 19:15<br>
                    Sun 16 Jun: 13:30 [c]<br>
                    Mon 17 Jun: 18:00 [c]<br>
                    Tue 18 Jun: 20:20<br>
                    Wed 19 Jun: 11:15,17:50<br>
                    Thu 20 Jun: 17:00<br>
                </mj-text>
            </mj-column>
        @endforeach
    </mj-section>
    <mj-section padding="0 0 50px">
        @foreach ($chunk as $film)
            <mj-column padding="0 {{ $loop->last ? 0 : '10px' }} 0 {{ !$loop->first ? '10px' : 0 }}"
                width="{{ 100 / $section->layout }}%">
                <mj-button inner-padding="5px 10px" font-weight="bold" width="100%" padding="0"
                    background-color="#ffda3d" color="#000000" href="{{ $film->url }}">More
                    info &amp; tickets
                </mj-button>
            </mj-column>
        @endforeach

    </mj-section>
@endforeach