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
             class="bg-sand-light z-10 sticky bottom-0 lg:static lg:bottom-auto lg:container lg:flex flex-row justify-between border-b border-sand lg:py-2.5">
             <div class="grid grid-cols-2 lg:flex flex-row items-center lg:gap-2.5">
                 <div class="type-xs-mono hidden lg:block">View:</div>
                 <x-programme-button :selected="$type" type="schedule">Schedule</x-programme-button>
                 <x-programme-button :selected="$type" type="alphabetical">A&ndash;Z</x-programme-button>
             </div>
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
                         <dialog x-ref="stranddialog" x-on:click.self="$refs.stranddialog.close()"
                             class="overflow-visible py-16 opacity-0 open:opacity-100 transition max-w-3xl px-16 rounded fixed top-1/2 m-0 w-full left-1/2 bg-sand p-12 z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
                             <form class="max-w-md mx-auto" method="dialog">
                                 <h3
                                     class="type-xs-mono lg:block top-[45%] lg:absolute lg:right-full origin-bottom lg:translate-x-full lg:-rotate-90 whitespace-nowrap">
                                     Filter by strand</h3>
                                 <div class="grid grid-cols-3 gap-4">
                                     @foreach ($strands_with_showings as $strand)
                                         <button aria-label="Filter to show {{ $strand->name }} screenings"
                                             wire:click="$emit('updateStrand', '{{ $strand->slug }}' )"
                                             style="color: {{ $strand->color }}"
                                             class="type-xs-mono rounded-full hover:bg-current">
                                             @icon($strand->logo, ' px-4 p-2 pb-1 w-full h-auto')
                                         </button>
                                     @endforeach
                                 </div>
                                 <button aria-label="Cancel" value="cancel"
                                     class="type-xs-mono absolute top-full mt-4 left-1/2 !leading-none -translate-x-1/2 flex flex-row items-center rounded-full text-white bg-black-light pr-4">
                                     @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                                     Close
                                 </button>
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
                     <dialog x-ref="accessdialog" x-on:click.self="$refs.stranddialog.close()"
                         class="overflow-visible py-16 opacity-0 open:opacity-100 transition max-w-3xl px-16 rounded fixed top-1/2 m-0 w-full left-1/2 bg-sand p-12 z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
                         <form class="max-w-md mx-auto" method="dialog">
                             <h3
                                 class="type-xs-mono lg:block top-[45%] lg:absolute lg:right-full origin-bottom lg:translate-x-full lg:-rotate-90 whitespace-nowrap">
                                 Filter by access</h3>
                             <div class="grid grid-cols-2 gap-4">
                                 @foreach ($accessibilities_with_showings as $accessibility)
                                     <button wire:click="$emit('updateAccessibility', '{{ $accessibility['slug'] }}' )"
                                         class="type-xs-mono group transition text-center bg-gray hover:bg-yellow py-8 rounded whitespace-nowrap px-4">
                                         <span
                                             class="type-xs-mono rounded-full text-center inline-block bg-white group-hover:bg-black group-hover:text-white transition px-2">{{ $accessibility['abbreviation'] }}</span>

                                         <p class="mt-2">{{ $accessibility['label'] }}
                                         </p>
                                     </button>
                                 @endforeach
                             </div>
                             <button aria-label="Cancel" value="cancel"
                                 class="type-xs-mono absolute top-full mt-4 left-1/2 !leading-none -translate-x-1/2 flex flex-row items-center rounded-full text-white bg-black-light pr-4">
                                 @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                                 Close
                             </button>
                         </form>
                     </dialog>

                 @endif

                 @if ($date)
                     <button wire:key="remove-data-filter" aria-label="Remove data filter"
                         class="type-xs-mono cursor-default rounded bg-yellow hover:bg-yellow-dark pt-2 py-1.5 px-3"
                         wire:click="$emit('updateDate', null)">
                         {{ date('d M', strtotime($date)) }}
                         @svg('plus', 'rotate-45 inline-block ml-1 align-top w-3 h-3')</button>
                 @else
                     <button x-on:click="$refs.datedialog.showModal()"
                         class="type-xs-mono cursor-default rounded bg-sand hover:bg-sand-dark pt-2 py-1.5 px-3">
                         Date
                         @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                     <dialog x-ref="datedialog"
                         class="overflow-visible py-16 opacity-0 open:opacity-100 transition max-w-3xl px-16 rounded fixed top-1/2 m-0 w-full left-1/2 bg-sand p-12 z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
                         <form class="max-w-md mx-auto" method="dialog">
                             <h3
                                 class="type-xs-mono lg:block top-[45%] lg:absolute lg:right-full origin-bottom lg:translate-x-full lg:-rotate-90 whitespace-nowrap">
                                 Filter by date</h3>
                             <x-datepicker />
                             <button aria-label="Cancel" value="cancel"
                                 class="type-xs-mono absolute top-full mt-4 left-1/2 !leading-none -translate-x-1/2 flex flex-row items-center rounded-full text-white bg-black-light pr-4">
                                 @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                                 Close
                             </button>
                         </form>

                     </dialog>
                 @endif
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

         <x-newsletter-card />
     </div>
 </div>
