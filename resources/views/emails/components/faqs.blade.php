     <mj-section full-width="full-width" padding="40px 0" background-color="#000000">
      

         <x-email.heading type="regular" align="center" color="#ffda3d">Frequently Asked Questions</x-email.heading>
         <mj-spacer height="15px" />

         <mj-accordion>
             @foreach ($settings['email_faqs'] as $faq)
                 <mj-accordion-element>
                     <mj-accordion-title @if (!$loop->last) border="1px solid #393939" @endif
                         font-size="14px" padding="10px 0" background-color="#000000" color="#ffffff"
                         font-weight="bold">
                         
                         {{ $faq['question'] }}
                         </mj-accordion-title>
                     <mj-accordion-text background-color="#000000" color="#ffffff">
                         {!! Str::of($faq['answer'])->replace('<a ', '<a style="color:#ffda3d" ') !!}
                     </mj-accordion-text>
                 </mj-accordion-element>
             @endforeach

         </mj-accordion>

     </mj-section>
