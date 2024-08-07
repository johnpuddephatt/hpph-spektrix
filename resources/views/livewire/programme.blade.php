 {{-- Outer wrapper <div> needed for LiveWire --}}

 <div>
     <div class="bg-sand container pt-36 pb-6 flex flex-row items-end justify-between">

         <h1 class="type-medium lg:type-large">
             What’s on <span class="type-medium !font-normal" x-show="count" x-data="{ count: null }"
                 @eventcount.window="count = $event.detail.number" x-text="`[${count} result${count > 1 ? 's' : ''}]`">
         </h1>

         </p>
     </div>

     <div class="flex flex-col lg:block">
         <div
             class="bg-sand-light z-10 sticky bottom-0 lg:static lg:bottom-auto lg:container lg:flex flex-row-reverse justify-between border-b border-yellow-dark lg:border-sand lg:py-2.5">

             <div class="grid grid-cols-3 px-4 py-3 lg:p-0 lg:flex flex-row items-center gap-4 lg:gap-2.5">
                 <div class="type-xs-mono hidden lg:block">Filter:</div>

                 @if ($strand)
                     <button wire:key="remove-strand-filter" aria-label="Remove filter for {{ $strand }}"
                         class="type-xs-mono cursor-default rounded bg-yellow hover:bg-yellow-dark pt-2 py-1.5 px-3"
                         wire:click="$emit('updateStrand', null)">

                         {{ $strands_with_showings->firstWhere('slug', $strand)->name }}
                         @svg('plus', 'rotate-45 align-top inline-block ml-1 w-3 h-3')</button>
                 @else
                     @if (count($strands_with_showings))

                         <button x-on:click="$refs.stranddialog.showModal()"
                             class="type-xs-mono cursor-default rounded bg-sand hover:bg-sand-dark pt-2 py-1.5 px-3">
                             Strands
                             @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                         <dialog x-trap="$el.open" x-ref="stranddialog" x-on:click.self="$refs.stranddialog.close()"
                             class="overflow-visible opacity-0 open:opacity-100 transition rounded fixed top-1/2 m-0 p-0 w-[40rem] max-w-[90%] left-1/2 bg-sand z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
                             <form class="px-8 py-16 md:px-16" method="dialog">
                                 <div class="max-w-md mx-auto">
                                     <h3
                                         class="type-xs-mono mb-6 lg:block top-[45%] lg:absolute lg:right-full origin-bottom lg:translate-x-full lg:-rotate-90 whitespace-nowrap">
                                         Filter by strand</h3>
                                     <div class="grid grid-cols-3 gap-4">
                                         @foreach ($strands_with_showings as $strand)
                                             <button aria-label="Filter to show {{ $strand->name }} screenings"
                                                 wire:click="$emit('updateStrand', '{{ $strand->slug }}' )"
                                                 style="color: {{ $strand->color }}"
                                                 class="type-xs-mono h-20 flex flex-row items-center rounded-full bg-sand-dark hover:bg-current">
                                                 @if ($strand->logo_simple)
                                                     @icon($strand->logo_simple, ' px-4 md:px-8 py-2 md:py-4 max-h-[4.5rem] w-full h-auto')
                                                 @else
                                                     <div class="text-xs-mono text-black px-4 p-2 pb-1 w-full h-auto">
                                                         {{ $strand->name }}</div>
                                                 @endif
                                             </button>
                                         @endforeach
                                     </div>
                                     <button aria-label="Close strand filter" value="cancel"
                                         class="type-xs-mono overflow-hidden absolute top-full mt-4 left-1/2 !leading-none -translate-x-1/2 flex flex-row items-center rounded-full text-white bg-black-light hover:bg-black transition border border-black pr-4">
                                         @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                                         Close
                                     </button>
                                 </div>
                             </form>
                         </dialog>

                     @endif
                 @endif

                 @if (count($accessibilities_with_showings))

                     @if ($accessibility)
                         <button aria-label="Remove accessibility filter" wire:key="remove-accessibility"
                             class="type-xs-mono cursor-default rounded bg-yellow hover:bg-yellow-dark pt-2 py-1.5 px-3"
                             wire:click="$emit('updateAccessibility', null)">
                             {{ $accessibilities_with_showings->firstWhere('slug', $accessibility)['label'] }}
                             @svg('plus', 'rotate-45 align-top inline-block ml-1 w-3 h-3')</button>
                     @else
                         <button x-on:click="$refs.accessdialog.showModal()"
                             class="type-xs-mono cursor-default rounded bg-sand hover:bg-sand-dark pt-2 py-1.5 px-3">
                             Access
                             @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                     @endif
                     <dialog x-trap="$el.open" x-ref="accessdialog" x-on:click.self="$refs.accessdialog.close()"
                         class="overflow-visible opacity-0 open:opacity-100 transition w-[40rem] max-w-[90%] rounded fixed top-1/2 m-0 left-1/2 bg-sand p-0 z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
                         <form class="px-8 py-16 md:px-16" method="dialog">
                             <div class="max-w-md mx-auto">
                                 <h3
                                     class="type-xs-mono mb-6 top-[45%] md:absolute md:right-full origin-bottom md:translate-x-full md:-rotate-90 whitespace-nowrap">
                                     Filter by access</h3>
                                 <div class="grid md:grid-cols-2 gap-2 md:gap-4">
                                     @foreach ($accessibilities_with_showings as $accessibility)
                                         <button
                                             wire:click="$emit('updateAccessibility', '{{ $accessibility['slug'] }}' )"
                                             class="type-xs-mono group p-4 justify-between transition max-md:flex text-center bg-sand-dark items-center flex-row-reverse gap-4 hover:bg-yellow md:py-8 rounded whitespace-nowrap px-4">
                                             <span
                                                 class="type-xs-mono rounded-full text-center inline-block bg-white group-hover:bg-black group-hover:text-white transition px-2">{{ $accessibility['abbreviation'] }}</span>

                                             <p class="md:mt-2">{{ $accessibility['label'] }}
                                             </p>
                                         </button>
                                     @endforeach
                                 </div>
                                 <button aria-label="Close accessibility filter" value="cancel"
                                     class="type-xs-mono overflow-hidden absolute top-full mt-4 left-1/2 !leading-none -translate-x-1/2 flex flex-row items-center rounded-full text-white bg-black-light hover:bg-black transition border border-black pr-4">
                                     @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                                     Close
                                 </button>
                             </div>
                         </form>
                     </dialog>

                 @endif

                 @if ($date)
                     <button wire:key="remove-date-filter" aria-label="Remove date filter"
                         class="type-xs-mono cursor-default rounded bg-yellow hover:bg-yellow-dark pt-2 py-1.5 px-3"
                         wire:click="$emit('updateDate', null)">
                         {{ date('d M', strtotime($date)) }}
                         @svg('plus', 'rotate-45 inline-block ml-1 align-top w-3 h-3')</button>
                 @else
                     <button x-on:click="$refs.datedialog.showModal()"
                         class="type-xs-mono cursor-default rounded bg-sand hover:bg-sand-dark pt-2 py-1.5 px-3">
                         Date
                         @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                     <dialog x-trap="$el.open" x-ref="datedialog" x-on:click.self="$refs.datedialog.close()"
                         class="p-0 overflow-visible opacity-0 open:opacity-100 transition rounded fixed top-1/2 m-0 w-[40rem] max-w-[90%] left-1/2 bg-sand z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
                         <form class="px-8 py-16 md:px-16" method="dialog">
                             <div class="max-w-md mx-auto">
                                 <h3
                                     class="type-xs-mono text-center mb-6 lg:block top-[45%] lg:absolute lg:right-full origin-bottom lg:translate-x-full lg:-rotate-90 whitespace-nowrap">
                                     Filter by date</h3>
                                 <x-datepicker />
                                 <button aria-label="Close date filter" value="cancel"
                                     class="type-xs-mono overflow-hidden absolute top-full mt-4 left-1/2 !leading-none -translate-x-1/2 flex flex-row items-center rounded-full text-white bg-black-light pr-4">
                                     @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                                     Close
                                 </button>
                             </div>
                         </form>

                     </dialog>
                 @endif
             </div>
             <div class="grid grid-cols-2 lg:flex flex-row items-center lg:gap-2.5">
                 <div class="type-xs-mono hidden lg:block">View:</div>
                 <x-programme-button :selected="$type" type="alphabetical">A&ndash;Z</x-programme-button>
                 <x-programme-button :selected="$type" type="schedule">Schedule</x-programme-button>
             </div>
         </div>

         <div class="bg-sand -order-1">
             @if ($type == 'alphabetical')
                 <livewire:programme.alphabetical wire-key="alphabetical" />
             @elseif ($type == 'schedule')
                 <livewire:programme.instances wire-key="instances" :show_header="false" :show_load_more="true"
                     :options="[(array) ['limit' => 10]]" />
             @endif
         </div>

     </div>
 </div>
