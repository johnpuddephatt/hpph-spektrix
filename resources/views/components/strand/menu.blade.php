 @if ($strands->count())
     <div class="sticky bottom-0 lg:static lg:w-5/12" x-data="{ open: false }">

         <div class="bg-black divide-y-2 divide-black lg:pt-0 lg:!block fixed lg:static inset-0 right-auto z-10 h-screen w-full transform overscroll-contain overflow-y-auto text-base text-white transition-all delay-100 duration-200"
             x-show="open" x-transition:enter-start="max-lg:-translate-x-16 max-lg:opacity-0"
             x-transition:leave-end="max-lg:-translate-x-16 max-lg:opacity-0">

             <button class="lg:hidden m-4" @click="open = false"
                 aria-label="Close programme strands menu">@svg('arrow-right', 'transform rotate-180 w-10 h-10 rounded-full bg-black-light p-2.5')</button>

             @foreach ($strands as $strand)
                 <a style="color: {{ $strand->color }} !important;"
                     href="{{ route('strand.show', ['strand' => $strand->slug]) }}"
                     class="group pt-[100%] lg:pt-[75%] block relative text-center">

                     @if ($strand->featuredImage)
                         {!! $strand->featuredImage->img('landscape')->attributes([
                             'data-width' => '600px',
                             'class' =>
                                 'absolute h-full inset-0 object-cover object-center block w-full opacity-50 lg:group-hover:opacity-20 transition',
                         ]) !!}
                     @else
                         <div
                             class="absolute h-full inset-0 bg-white object-cover object-center block w-full opacity-10 lg:group-hover:opacity-0 transition">
                         </div>
                     @endif

                     @if ($strand->logo)
                         @icon($strand->logo, ' group-hover:delay-[0ms] delay-100 lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-64 max-w-full px-8')
                     @else
                         <h3
                             class="type-h4 lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-72 max-w-full px-8">
                             {{ $strand->name }}</h3>
                     @endif
                     <p
                         class="type-xs-mono w-full px-8 max-w-xs lg:px-0 lg:group-hover:opacity-100 lg:opacity-0 transition lg:group-hover:translate-y-1/2 left-1/2 transform -translate-x-1/2 absolute bottom-6 lg:bottom-1/2 mx-auto lg:w-64">
                         {{ $strand->short_description }}</p>

                     @svg('arrow-right', ' group-hover:delay-50 hidden lg:inline-block absolute bottom-8 -translate-x-1/2 left-1/2 transition w-9 h-9 p-2 rounded-full text-transparent group-hover:text-black bg-yellow transform -rotate-45 origin-center group-hover:scale-100 scale-[0.4]', ['style' => 'background-color: ' . $strand->color])

                 </a>
             @endforeach
         </div>

         <button class="type-regular items-center w-full flex lg:hidden relative px-6 py-4 text-black bg-yellow"
             @click="open = ! open; $dispatch('menutoggled', open)">{{ $slot }}</button>

     </div>
 @else
     <div class="w-5/12"></div>
 @endif
