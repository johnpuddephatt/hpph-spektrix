<mjml>
    <mj-head>
        <mj-font name="BasisGrotesque" href="{{ url('build/assets/fonts.css') }}" />

        <mj-attributes>

            <mj-all line-height="1.6" font-family="BasisGrotesque, sans-serif" />
            <mj-accordion padding="0 0 0 15px" border="none" />
            <mj-accordion-element icon-unwrapped-url="https://i.imgur.com/Xvw0vjq.png"
                icon-wrapped-url="https://i.imgur.com/KKHenWa.png" icon-height="8px" icon-width="8px" padding="0" />
            <mj-accordion-title align="center" background-color="#f8f7f0" padding="7px 10px""
                color=" #031017" />
            <mj-accordion-text background-color="#fafafa" padding="15px 10px" color="#505050" font-size="14px" />
        </mj-attributes>

        <mj-style inline="inline">
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
            .film-column-hero {max-width: none !important;
            }
            }
        </mj-style>
    </mj-head>

    <mj-body>
        <mj-section padding="0">
            <mj-text align="center">
                <a href="https://$UNSUB$">Unsubscribe from this email</a>
            </mj-text>
        </mj-section>
        <mj-wrapper background-color="#000" padding="0px 0 10px" full-width="full-width">
            <mj-section full-width="full-width" padding="0px 0 0px ">

                <mj-image align="center" padding="0" src="https://hpph.ams3.cdn.digitaloceanspaces.com/hpph.gif" />
                <mj-text font-size="24px" align="center" color="#ffda3d" line-height="1.2" font-weight="700">
                    {{ $email->title }}</mj-text>

            </mj-section>
        </mj-wrapper>

        @if ($email->settings['key'])
            @include('emails.components.key')
        @endif

        @foreach ($email->content as $section)
            @include('emails.sections.' . $section->name(), ['section' => $section])
        @endforeach

    </mj-body>
</mjml>
