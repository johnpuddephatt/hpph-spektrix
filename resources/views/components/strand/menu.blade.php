 @if ($strands->count())
     <div class="sticky bottom-0 md:static md:w-1/2 lg:w-1/3" x-data="{ open: false }">

         <div class="h-dynamic-screen sticky inset-0 right-auto z-10 w-full transform divide-y-2 divide-black overflow-y-auto overscroll-contain bg-black text-base text-white transition-all delay-100 duration-200 md:static md:!block lg:pt-0"
             x-show="open" x-transition:enter-start="max-lg:translate-x-full"
             x-transition:leave-end="max-lg:translate-x-full">

             <button class="mx-4 my-2.5 md:hidden" @click="open = false"
                 aria-label="Close programme strands menu">@svg('arrow-right', 'transform rotate-180 w-10 h-10 rounded-full bg-black-light p-2.5')</button>

             @foreach ($strands as $strand)
                 <a style="color: {{ $strand->color }} !important;"
                     href="{{ route('strand.show', ['strand' => $strand->slug]) }}"
                     class="group relative block overflow-hidden pt-[100%] text-center lg:pt-[75%]">

                     @if ($strand->featuredImage)
                         {!! $strand->featuredImage->img('landscape')->attributes([
                             'data-width' => '600px',
                             'loading' => 'lazy',
                             'class' =>
                                 'absolute h-full inset-0 object-cover object-center block w-full opacity-50 group-hover:scale-105 lg:group-hover:opacity-20 duration-500 transition',
                         ]) !!}
                     @else
                         <div
                             class="absolute inset-0 block h-full w-full bg-white object-cover object-center opacity-10 transition lg:group-hover:opacity-0">
                         </div>
                     @endif

                     @if ($strand->logo)
                         {{-- @icon($strand->logo, ' group-hover:delay-[0ms] delay-100 lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-64 lg:w-72 max-w-full px-8') --}}
                         <img src="{{ Storage::url($strand->logo) }}" alt="{{ $strand->name }} logo" loading="lazy"
                             class="absolute left-1/2 top-1/2 z-10 mx-auto w-64 max-w-full -translate-x-1/2 -translate-y-1/2 transform px-8 delay-100 group-hover:delay-[0ms] lg:w-72 lg:group-hover:-translate-y-full lg:group-hover:opacity-0" />
                     @else
                         <h3
                             class="type-h4 absolute left-1/2 top-1/2 z-10 mx-auto w-72 max-w-full -translate-x-1/2 -translate-y-1/2 transform px-8 lg:group-hover:-translate-y-full lg:group-hover:opacity-0">
                             {{ $strand->name }}</h3>
                     @endif
                     <p
                         class="type-xs-mono absolute bottom-6 left-1/2 mx-auto w-full max-w-xs -translate-x-1/2 transform px-8 transition lg:bottom-1/2 lg:w-64 lg:px-0 lg:opacity-0 lg:group-hover:translate-y-1/2 lg:group-hover:opacity-100">
                         {{ $strand->short_description }}</p>

                     @svg('arrow-right', ' group-hover:delay-50 hidden lg:inline-block absolute bottom-8 -translate-x-1/2 left-1/2 transition w-9 h-9 p-2 rounded-full text-transparent group-hover:text-black bg-yellow transform origin-center group-hover:scale-100 scale-[0.4]', ['style' => 'background-color: ' . $strand->color])

                 </a>
             @endforeach
         </div>

         <button class="type-regular relative flex w-full items-center bg-yellow px-6 py-4 text-black md:hidden"
             @click="open = ! open; $dispatch('menutoggled', open)">{{ $slot }}</button>

     </div>
 @else
     <div class="w-5/12"></div>
 @endif
