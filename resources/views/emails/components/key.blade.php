 <mj-wrapper background-color="#f8f7ef" padding="7px 0" full-width="full-width">
     <mj-section padding="0">
         <mj-text align="center">
             <div id="screeningkey">
                 Key:&nbsp;&nbsp;
                 <a style="color: black;"
                     href="https://hpph.co.uk/access#accessible-screenings">@include('emails.components.accessibility_icon', [
                         'label' => 'Signed in British Sign Language',
                         'abbreviation' => 'BSL',
                     ]) British Sign
                     Language</a>

                 &nbsp;&nbsp; <a style="color: black;"
                     href="https://hpph.co.uk/access#accessible-screenings">@include('emails.components.accessibility_icon', [
                         'label' => 'Captioned',
                         'abbreviation' => 'C',
                     ]) Captioned</a>

                 &nbsp;&nbsp; <a style="color: black;"
                     href="https://hpph.co.uk/access#accessible-screenings">@include('emails.components.accessibility_icon', [
                         'label' => 'Audio Described',
                         'abbreviation' => 'AD',
                     ])
                     Audio Described</a>

                 &nbsp;&nbsp; <a style="color: black;"
                     href="https://hpph.co.uk/access#accessible-screenings">@include('emails.components.accessibility_icon', [
                         'label' => 'Autism Friendly',
                         'abbreviation' => 'AF',
                     ]) Autism
                     Friendly</a>
             </div>
         </mj-text>
     </mj-section>
 </mj-wrapper>
