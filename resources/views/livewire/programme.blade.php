 {{-- Outer wrapper <div> needed for LiveWire --}}

 <div x-data="{ filtersOpen: false, viewOpen: false }">

     <div class="container relative z-[14] flex flex-row items-end justify-between gap-2 bg-sand pb-6 pt-36">
         @if (!$type === 'past')
             <h1 class="type-medium lg:type-large">
                 Past screenings
             </h1>
         @else
             <h1 class="type-medium lg:type-large">
                 What’s on <span class="type-medium !font-normal" x-show="count" x-data="{ count: null }"
                     @eventcount.window="count = $event.detail.number"
                     x-text="`[${count} result${count > 1 ? 's' : ''}]`">
             </h1>
         @endif

         <button @click="viewOpen = false; filtersOpen = !filtersOpen" :class="{ '!bg-sand-dark': filtersOpen }"
             class="type-xs-mono ml-auto !rounded bg-sand-light !py-1.5 px-4 !text-black lg:hidden">

             Filter

             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="inline-block h-4 w-4 align-middle">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
             </svg>

         </button>
         <button @click="filtersOpen = false; viewOpen = !viewOpen" :class="{ '!bg-sand-dark': viewOpen }"
             class="type-xs-mono !rounded bg-sand-light !py-1.5 px-4 !text-black lg:hidden">{{ match ($type) {'past' => 'Archive','alphabetical' => 'A-Z',default => 'Daily'} }}

             view
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="inline-block h-4 w-4 align-middle">
                 <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
             </svg>

         </button>

     </div>

     <div class="flex flex-col bg-sand lg:block">
         <div
             class="z-[11] flex-row-reverse justify-between border-b border-sand border-yellow-dark bg-sand-light transition lg:container before:absolute before:bottom-full before:left-0 before:right-0 before:-z-10 before:hidden before:h-[3.75rem] before:bg-sand lg:sticky lg:bottom-auto lg:top-[3.75rem] lg:flex lg:translate-y-0 lg:py-2.5 lg:pr-14 lg:before:block">

             <div x-cloak :class="{ '': filtersOpen, ' max-lg:max-h-0 max-lg:overflow-hidden': !filtersOpen }"
                 class="flex-row items-center lg:flex lg:gap-2.5">
                 @if ($type !== 'past')
                     <div class="type-xs-mono hidden lg:block">Filter:</div>

                     <div class="grid grid-cols-3 flex-row items-center gap-4 px-4 py-3 lg:flex lg:gap-2.5 lg:p-0">

                         @if ($strand)
                             <button wire:key="remove-strand-filter" aria-label="Remove filter for {{ $strand }}"
                                 class="type-xs-mono cursor-default rounded bg-yellow px-3 py-1.5 pt-2 hover:bg-yellow-dark"
                                 wire:click="$dispatch('updateStrand', {slug: null})">

                                 {{ $strands_with_showings->firstWhere('slug', $strand)->name }}
                                 @svg('plus', 'rotate-45 align-top inline-block ml-1 w-3 h-3')</button>
                         @else
                             @if (count($strands_with_showings))

                                 <button x-on:click="$refs.stranddialog.showModal()"
                                     class="type-xs-mono cursor-default rounded bg-sand px-3 py-1.5 pt-2 hover:bg-sand-dark">
                                     Strands
                                     @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                                 <dialog x-trap="$el.open" x-ref="stranddialog"
                                     x-on:click.self="$refs.stranddialog.close()"
                                     class="fixed left-1/2 top-1/2 z-40 m-0 w-[40rem] max-w-[90%] -translate-x-1/2 -translate-y-1/2 transform overflow-visible rounded bg-sand p-0 opacity-0 transition backdrop:bg-black backdrop:bg-opacity-60 backdrop:backdrop-blur-lg open:opacity-100">
                                     <form class="px-8 py-16 md:px-16" method="dialog">
                                         <div class="mx-auto max-w-md">
                                             <h3
                                                 class="type-xs-mono top-[45%] mb-6 origin-bottom whitespace-nowrap lg:absolute lg:right-full lg:block lg:translate-x-full lg:-rotate-90">
                                                 Filter by strand</h3>
                                             <div class="grid grid-cols-3 gap-4">
                                                 @foreach ($strands_with_showings as $strand)
                                                     <button aria-label="Filter to show {{ $strand->name }} screenings"
                                                         wire:click="$dispatch('updateStrand', {slug: '{{ $strand->slug }}'} )"
                                                         style="color: {{ $strand->color }}"
                                                         class="type-xs-mono flex h-20 flex-row items-center rounded-full bg-sand-dark hover:bg-current">
                                                         @if ($strand->logo_simple)
                                                             @icon($strand->logo_simple, ' px-4 md:px-8 py-2 md:py-4 max-h-[4.5rem] w-full h-auto')
                                                         @else
                                                             <div
                                                                 class="text-xs-mono h-auto w-full p-2 px-4 pb-1 text-black">
                                                                 {{ $strand->name }}</div>
                                                         @endif
                                                     </button>
                                                 @endforeach
                                             </div>
                                             <button aria-label="Close strand filter" value="cancel"
                                                 class="type-xs-mono absolute left-1/2 top-full mt-4 flex -translate-x-1/2 flex-row items-center overflow-hidden rounded-full border border-black bg-black-light pr-4 !leading-none text-white transition hover:bg-black">
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
                                     class="type-xs-mono cursor-default rounded bg-yellow px-3 py-1.5 pt-2 hover:bg-yellow-dark"
                                     wire:click="$dispatch('updateAccessibility', {slug: null})">
                                     {{ $accessibilities_with_showings->firstWhere('slug', $accessibility)['label'] }}
                                     @svg('plus', 'rotate-45 align-top inline-block ml-1 w-3 h-3')</button>
                             @else
                                 <button x-on:click="$refs.accessdialog.showModal()"
                                     class="type-xs-mono cursor-default rounded bg-sand px-3 py-1.5 pt-2 hover:bg-sand-dark">
                                     Access
                                     @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                             @endif
                             <dialog x-trap="$el.open" x-ref="accessdialog" x-on:click.self="$refs.accessdialog.close()"
                                 class="fixed left-1/2 top-1/2 z-40 m-0 w-[40rem] max-w-[90%] -translate-x-1/2 -translate-y-1/2 transform overflow-visible rounded bg-sand p-0 opacity-0 transition backdrop:bg-black backdrop:bg-opacity-60 backdrop:backdrop-blur-lg open:opacity-100">
                                 <form class="px-8 py-16 md:px-16" method="dialog">
                                     <div class="mx-auto max-w-md">
                                         <h3
                                             class="type-xs-mono top-[45%] mb-6 origin-bottom whitespace-nowrap md:absolute md:right-full md:translate-x-full md:-rotate-90">
                                             Filter by access</h3>
                                         <div class="grid gap-2 md:grid-cols-2 md:gap-4">
                                             @foreach ($accessibilities_with_showings as $accessibility)
                                                 <button
                                                     wire:click="$dispatch('updateAccessibility', {slug: '{{ $accessibility['slug'] }}'})"
                                                     class="type-xs-mono group flex-row-reverse items-center justify-between gap-4 whitespace-nowrap rounded bg-sand-dark p-4 px-4 text-center transition hover:bg-yellow max-md:flex md:py-8">
                                                     <span
                                                         class="type-xs-mono inline-block rounded-full bg-white px-2 text-center transition group-hover:bg-black group-hover:text-white">{{ $accessibility['abbreviation'] }}</span>

                                                     <p class="md:mt-2">{{ $accessibility['label'] }}
                                                     </p>
                                                 </button>
                                             @endforeach
                                         </div>
                                         <button aria-label="Close accessibility filter" value="cancel"
                                             class="type-xs-mono absolute left-1/2 top-full mt-4 flex -translate-x-1/2 flex-row items-center overflow-hidden rounded-full border border-black bg-black-light pr-4 !leading-none text-white transition hover:bg-black">
                                             @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                                             Close
                                         </button>
                                     </div>
                                 </form>
                             </dialog>

                         @endif

                         @if ($date)
                             <button wire:key="remove-date-filter" aria-label="Remove date filter"
                                 class="type-xs-mono cursor-default rounded bg-yellow px-3 py-1.5 pt-2 hover:bg-yellow-dark"
                                 wire:click="$dispatch('updateDate', { date: null})">
                                 {{ date('d M', strtotime($date)) }}
                                 @svg('plus', 'rotate-45 inline-block ml-1 align-top w-3 h-3')</button>
                         @else
                             <button x-on:click="$refs.datedialog.showModal()"
                                 class="type-xs-mono cursor-default rounded bg-sand px-3 py-1.5 pt-2 hover:bg-sand-dark">
                                 Date
                                 @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                             <dialog x-trap="$el.open" x-ref="datedialog" x-on:click.self="$refs.datedialog.close()"
                                 class="fixed left-1/2 top-1/2 z-40 m-0 w-[40rem] max-w-[90%] -translate-x-1/2 -translate-y-1/2 transform overflow-visible rounded bg-sand p-0 opacity-0 transition backdrop:bg-black backdrop:bg-opacity-60 backdrop:backdrop-blur-lg open:opacity-100">
                                 <form class="px-8 py-16 md:px-16" method="dialog">
                                     <div class="mx-auto max-w-md">
                                         <h3
                                             class="type-xs-mono top-[45%] mb-6 origin-bottom whitespace-nowrap text-center lg:absolute lg:right-full lg:block lg:translate-x-full lg:-rotate-90">
                                             Filter by date</h3>
                                         <x-datepicker />
                                         <button aria-label="Close date filter" value="cancel"
                                             class="type-xs-mono absolute left-1/2 top-full mt-4 flex -translate-x-1/2 flex-row items-center overflow-hidden rounded-full bg-black-light pr-4 !leading-none text-white">
                                             @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                                             Close
                                         </button>
                                     </div>
                                 </form>

                             </dialog>
                         @endif
                     </div>
                 @endif
             </div>

             <div x-cloak :class="{ '': viewOpen, ' max-lg:max-h-0 max-lg:overflow-hidden': !viewOpen }">
                 <div class="grid grid-cols-3 flex-row items-center gap-2.5 px-4 py-3 lg:flex lg:p-0">

                     <div class="type-xs-mono hidden lg:block">View:</div>
                     <x-programme-button :selected="$type" type="schedule">Schedule</x-programme-button>
                     <x-programme-button :selected="$type" type="alphabetical">A&ndash;Z</x-programme-button>
                     {{-- <x-programme-button :selected="$type" type="daily">Daily</x-programme-button> --}}

                     <x-programme-button :selected="$type" type="past">Archive</x-programme-button>
                 </div>
             </div>

         </div>

         <div class="bg-sand pb-12">
             @if ($type == 'alphabetical')
                 <livewire:programme.alphabetical wire-key="alphabetical" :type="$type" />
             @elseif($type == 'past')
                 <livewire:programme.alphabetical wire-key="past" :type="$type" />
             @elseif ($type == 'daily')
                 <livewire:programme.daily wire:key="daily" :type="$type" />
             @elseif ($type == 'schedule')
                 <livewire:programme.instances wire-key="instances" :show_header="false" :show_load_more="true"
                     :options="[(array) ['limit' => 10]]" />
             @endif
         </div>

     </div>
 </div>
