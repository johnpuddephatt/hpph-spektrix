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
    </mj-head>

    <mj-body>
        <mj-section padding="0">
            <mj-text align="center">
                <a href="https://$UNSUB$">Unsubscribe from this email</a>
            </mj-text>
        </mj-section>
        <mj-wrapper background-color="#000000" full-width="full-width">
            <mj-section padding="10px 0 ">

                <mj-image
                    src="https://ci3.googleusercontent.com/meips/ADKq_NYz45jqHv05Rc1o6-hUemFiFTeb2GoX-cjsbOFVQjMnlmxJhWDV3IlLfu0uVMW6KH24WBe9gSut4sfe_xH-EiItiSTUPemM14r_ui29707-GSp02si12jGFZj4DLsD7UyyMMdt7F3wxEw=s0-d-e1-ft#https://i.emlfiles4.com/cmpimg/2/1/0/0/8/2/files/1337082_hpphspinmailerheader_1.gif" />
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
