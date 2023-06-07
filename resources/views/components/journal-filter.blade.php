 <div
     class="max-lg:order-last container sticky bottom-0 flex flex-row justify-center lg:justify-start items-center gap-2 py-4 lg:pb-0 lg:pt-12 bg-sand-light lg:bg-transparent">
     <div class="type-xs-mono hidden lg:block">Filter:</div>

     @if ($selected_tag && $tags->firstWhere('slug', $selected_tag))
         <button wire:key="remove-tag-filter" aria-label="Remove filter for {{ $selected_tag }}"
             class="type-xs-mono cursor-default rounded bg-yellow hover:bg-yellow-dark pt-2 py-1.5 px-3"
             wire:click="$set('selected_tag', null)">

             {{ $tags->firstWhere('slug', $selected_tag)->name }}
             @svg('plus', 'rotate-45 align-top inline-block ml-1 w-3 h-3')</button>
     @else
         <button x-on:click="$refs.tagdialog.showModal()" aria-label="Select a filter"
             class="type-xs-mono cursor-default rounded bg-sand hover:bg-sand-dark lg:hover:bg-sand-light pt-2 py-1.5 px-3">
             <span class="hidden lg:inline">All</span>
             <span class="lg:hidden">Filter</span>
             @svg('plus', 'inline-block align-top ml-6 w-3 h-3')</button>
         <dialog x-trap="$el.open" x-ref="tagdialog" x-on:click.self="$refs.tagdialog.close()"
             class="overflow-visible opacity-0 open:opacity-100 transition rounded fixed top-1/2 m-0 p-0 w-[40rem] max-w-[90%] left-1/2 bg-sand z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
             <form class="px-8 py-16 md:px-16" method="dialog">
                 <div class="max-w-md mx-auto">
                     <h3
                         class="type-xs-mono mb-6 lg:block top-[45%] lg:absolute lg:right-full origin-bottom lg:translate-x-full lg:-rotate-90 whitespace-nowrap">
                         Filter by tag</h3>
                     <div class="grid lg:grid-cols-3 gap-4">
                         @foreach ($tags as $tag)
                             <button wire:click="$set('selected_tag', '{{ $tag->name }}')"
                                 class="type-xs-mono group p-4 transition text-center bg-sand-dark hover:bg-yellow md:py-8 rounded whitespace-nowrap px-4">
                                 {{ $tag->name }}
                             </button>
                         @endforeach
                     </div>

                     <button aria-label="Cancel" value="cancel"
                         class="type-xs-mono overflow-hidden absolute top-full mt-4 left-1/2 !leading-none -translate-x-1/2 flex flex-row items-center rounded-full text-white bg-black-light hover:bg-black transition border border-black pr-4">
                         @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                         Close
                     </button>
                 </div>
             </form>
         </dialog>

     @endif
 </div>
