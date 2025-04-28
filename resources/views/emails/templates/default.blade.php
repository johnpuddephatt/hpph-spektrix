<mjml>
    <mj-head>
        <mj-font name="BasisGrotesque" href="https://hpph.ams3.cdn.digitaloceanspaces.com/build/fonts.css" />
        <mj-font name="BasisGrotesqueMono" href="https://hpph.ams3.cdn.digitaloceanspaces.com/build/fonts.css" />

        <mj-attributes>

            <mj-all line-height="17px" letter-spacing="-0.21px" font-size="14px" font-family="BasisGrotesque, sans-serif" />
            <mj-accordion padding="0 0 0 0" border="none" />
            <mj-accordion-element icon-unwrapped-url="https://hpph.ams3.cdn.digitaloceanspaces.com/plus.png"
                icon-wrapped-url="https://hpph.ams3.cdn.digitaloceanspaces.com/plus.png" icon-height="16px"
                icon-width="16px" padding="0" />
            <mj-accordion-title align="center" background-color="#f8f7f0" padding="7px 10px""
                color=" #031017" />
            <mj-accordion-text background-color="#fafafa" padding="15px 10px" color="#505050" font-size="13px" />
        </mj-attributes>

        <mj-style inline="inline">

          .type-sm {
                color: red;
            }
            
            .mj-accordion-title td {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            font-weight: 600;

            }
            .mj-accordion-title td.mj-accordion-ico {
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            padding: 4px 10px !important;
            }

            

        </mj-style>
        <mj-style>
          

            @media only screen and (max-width:480px) {
                .film-column-hero {
                    max-width: none !important;
                }
            }

            .hidden-on-mobile {
            display: none;
            }

            @media only screen and (min-width:480px) {
            .hidden-on-mobile {
            display: block;
            }
            .show-on-mobile {
            display: none;
            }
            }
            @media only screen and (min-width:480px) {
            .pb0-on-desktop {
            padding-bottom: 0 !important;
            }
            }
        </mj-style>
    </mj-head>

    <mj-body padding="0">
       
        <mj-wrapper background-color="#000" padding="5px 0 25px" full-width="full-width">
            <mj-section  full-width="full-width" padding="0px 0 0px ">

                <mj-image align="center" padding="0" src="https://hpph.ams3.cdn.digitaloceanspaces.com/hpph.gif" />
                @if($email->title)
                  

                    <x-email.heading type="medium" align="center" color="#fff">
                    {{ $email->title }}
                    </x-email.heading>
                    @endif
                
                    

                      <x-email.heading type="regular" align="center" color="#fff">
                    Showing from {{ $email->date->format('D d M') }}
                    </x-email.heading>

            </mj-section>
        </mj-wrapper>

        @if ($email->settings['key'])
            @include('emails.components.key')
        @endif

        @if (is_iterable($email->content))
            @foreach ($email->content as $section)
                @include('emails.sections.' . $section->name(), ['section' => $section])
            @endforeach
        @endif

        @if ($email->settings['faqs'])
            @include('emails.components.faqs')
        @endif

        @if ($email->settings['social'])
            @include('emails.components.social')
        @endif

        <mj-section full-width="full-width" padding="15px 0" background-color="#000000" align="center">
            <mj-group>
                <mj-column width="22.5%"> </mj-column>

                <mj-column width="30%">
                    <mj-image padding="0 10px" src="https://hpph.ams3.cdn.digitaloceanspaces.com/lht-hpph.png"
                        alt="Leeds Heritage Theatres & HPPH" />
                </mj-column>
                <mj-column width="25%">
                    <mj-image padding="0 10px" src="https://hpph.ams3.cdn.digitaloceanspaces.com/lhf.png"
                        alt="Lottery Heritage Fund" />
                </mj-column>
                <mj-column width="22.5%"> </mj-column>
            </mj-group>
        </mj-section>

        <mj-section full-width="full-width" padding="10px 0 0 0" background-color="#000000">
            <mj-text align="center" color="#ffffff">
                <p class="text-xs">Copyright Hyde Park Picture House {{ date('Y') }}</p>
                @if (isset($settings['charity_number']))
                    <p class="text-xs">Registered Charity No.{{ $settings['charity_number'] }}</p>
                @endif
                <p>Address: {{ $settings['address'] }} &nbsp;&nbsp;&nbsp; Email: <a style="color: #ffffff"
                        href="mailto:info@hpph.co.uk">info@hpph.co.uk</a></p>
            </mj-text>
                 <mj-text align="center" padding="5px 0" color="#ffffff">
                <a style="color: white" href="https://$UNSUB$">Unsubscribe from this email</a>
            </mj-text>
        </mj-section>

    </mj-body>
</mjml>
