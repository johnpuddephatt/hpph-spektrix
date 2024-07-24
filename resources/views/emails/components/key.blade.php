 <mj-wrapper background-color="#f8f7ef" padding="7px 0" full-width="full-width">
     <mj-section padding="0">
         <mj-text align="center">
             <div id="screeningkey">

                 @include('emails.components.accessibility_icon', [
                     'label' => 'Signed in British Sign Language',
                     'abbreviation' => 'BSL',
                 ]) British Sign Language

                 &nbsp;&nbsp; @include('emails.components.accessibility_icon', [
                     'label' => 'Captioned',
                     'abbreviation' => 'C',
                 ]) Captioned

                 &nbsp;&nbsp; @include('emails.components.accessibility_icon', [
                     'label' => 'Audio Described',
                     'abbreviation' => 'AD',
                 ]) Audio Described

                 &nbsp;&nbsp; @include('emails.components.accessibility_icon', [
                     'label' => 'Autism Friendly',
                     'abbreviation' => 'AF',
                 ]) Autism Friendly
             </div>
         </mj-text>
     </mj-section>
 </mj-wrapper>
