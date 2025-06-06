@foreach ($films as $film)
    <mj-section padding="25px 0px 5px">
        <mj-group>
            <mj-column width="40%" padding="0 10px">

                <mj-hero css-class="film-row-hero" border-radius="5px" vertical-align="bottom" mode="fluid-height"
                    background-width="1200px" background-height="720px"
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
            <mj-column width="60%" padding="0 10px">
                
                <x-email.heading type="regular" padding="5px 0 10px 0">
                
                    {{ $film->name }}
                    @if ($film->certificate_age_guidance)
                        @include('emails.components.certificate_icon', [
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
                </x-email.heading>
                @if ($section->display_times == 'range' && $film->date_range)
                    <mj-text line-height="1.2" padding="0px 0 15px 0" font-weight="700" font-size="15px">
                        {!! $film->date_range !!}</mj-text>
                @endif
                <mj-text padding="0 0 0px 0">{!! $film->description !!}</mj-text>

            </mj-column>
        </mj-group>
    </mj-section>
    <mj-section @if (!$loop->last) border-bottom="1px solid #b5b5b5" @endif padding="0 0px 20px">
        <mj-group>
            <mj-column width="40%" padding="0 10px"></mj-column>
            <mj-column width="60%" padding="0 10px">
                @if ($section->display_times !== 'range')
                    @if ($section->display_times == 'collapsed' && $film->instances->count() > 2)
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
                <mj-button inner-padding="5px 10px" font-weight="bold"  width="100%" padding="0px 0px 0px 0"
                    background-color="#ffda3d" color="#000000" href="{{ $film->url }}">
                    Info &amp; tickets
                </mj-button>

           
            </mj-column>

        </mj-group>

    </mj-section>
@endforeach
