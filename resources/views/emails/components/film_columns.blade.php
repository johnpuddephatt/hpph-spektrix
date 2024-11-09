@foreach ($films->chunk($section->layout) as $chunk)
    @if (!$loop->first)
        <mj-divider border-width="1px" border-color="#b5b5b5" />
    @endif

    <mj-section padding="15px 0px">
        @foreach ($chunk as $film)
            <mj-column padding="15px 7.5px " css-class="pb0-on-desktop" width="{{ 100 / $section->layout }}%">
                <mj-hero css-class="film-column-hero" border-radius="5px" vertical-align="bottom" mode="fluid-height"
                    background-width="1200px" background-height="720px"
                    background-url="{{ $film->featuredImage?->getUrl('wide') }}" background-color="#2a3448"
                    padding="0px 0px">
                    @if ($film->strand && $film->strand->name !== 'Bring Your Own Baby')
                        <mj-button color="#000000" background-color="{{ $film->strand->color }}" width="100%"
                            line-height="1" padding="0px" font-size="11px" font-weight="bold" inner-padding="4px 0"
                            align="center">

                            {{ strtoupper($film->strand->name) }}
                        </mj-button>
                    @endif
                </mj-hero>
                <mj-text line-height="1.2" padding="10px 0" font-weight="700" font-size="18px">

                    {{ $film->name }}&#8239; @if ($film->certificate_age_guidance)
                        @include('emails.components.accessibility_icon', [
                            'label' => 'Certificate ' . $film->certificate_age_guidance,
                            'abbreviation' => $film->certificate_age_guidance,
                        ])
                    @endif

                    @if ($film->audio_description)
                        @include('emails.components.accessibility_icon', [
                            'label' => 'Audio Described',
                            'abbreviation' => 'AD',
                        ])
                    @endif
                </mj-text>
                @if ($section->display_times == 'range' && $film->date_range)
                    <mj-text font-family="BasisGrotesqueMono" line-height="1.2" padding="0px 0 15px 0" font-weight="700"
                        font-size="15px">
                        {!! $film->date_range !!}</mj-text>
                @endif
                <mj-text padding="0 0 15px">{!! $film->description !!}</mj-text>
                @if ($section->display_times !== 'range')
                    @if ($section->display_times == 'collapsed')
                        <mj-accordion>
                            <mj-accordion-element
                                icon-unwrapped-url="https://hpph.ams3.cdn.digitaloceanspaces.com/plus-black.png"
                                icon-wrapped-url="https://hpph.ams3.cdn.digitaloceanspaces.com/plus-black.png"
                                icon-height="16px" icon-width="16px" padding="0">
                                <mj-accordion-title>+ Toggle {{ $film->instances->count() }}
                                    showtime{{ $film->instances->count() > 1 ? 's' : '' }}
                                </mj-accordion-title>
                                <mj-accordion-text>
                                    @include('emails.components.instance_times')
                                </mj-accordion-text>
                            </mj-accordion-element>

                        </mj-accordion>
                    @else
                        @include('emails.components.instance_times')
                    @endif
                @endif
                <mj-button css-class="show-on-mobile" inner-padding="5px 10px" font-weight="bold" width="100%"
                    padding="15px 0 0" background-color="#ffda3d" color="#000000" href="{{ $film->url }}">More
                    info &amp; tickets
                </mj-button>
            </mj-column>
        @endforeach
    </mj-section>
    <mj-section css-class="hidden-on-mobile" padding="0 0 25px">
        @foreach ($chunk as $film)
            <mj-column padding="0 7.5px " width="{{ 100 / $section->layout }}%">
                <mj-button inner-padding="5px 10px" font-weight="bold" width="100%" padding="0"
                    background-color="#ffda3d" color="#000000" href="{{ $film->url }}">More
                    info &amp; tickets
                </mj-button>
            </mj-column>
        @endforeach
    </mj-section>
@endforeach
