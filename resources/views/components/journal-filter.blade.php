 <div
     class="container sticky bottom-0 flex flex-row items-center gap-2 bg-sand-light py-4 max-lg:order-last lg:bg-transparent lg:pb-0 lg:pt-12">
     @if (count($tags))
         <div class="type-xs-mono hidden lg:block">Filter:</div>

         @if ($selected_tag && $tags->firstWhere('slug', $selected_tag))
             <button wire:key="remove-tag-filter" aria-label="Remove filter for {{ $selected_tag }}"
                 class="type-xs-mono cursor-default rounded bg-yellow px-3 py-1.5 pt-2 hover:bg-yellow-dark"
                 wire:click="$set('selected_tag', null)">

                 {{ $tags->firstWhere('slug', $selected_tag)->name }}
                 @svg('plus', 'rotate-45 align-top inline-block ml-1 w-3 h-3')</button>
         @else
             <button x-on:click="$refs.tagdialog.showModal()" aria-label="Select a filter"
                 class="type-xs-mono cursor-default rounded bg-sand px-3 py-1.5 pt-2 hover:bg-sand-dark lg:hover:bg-sand-light">
                 <span class="hidden lg:inline">All</span>
                 <span class="lg:hidden">Filter</span>
                 @svg('plus', 'inline-block align-top ml-6 w-3 h-3')</button>
             <dialog x-trap="$el.open" x-ref="tagdialog" x-on:click.self="$refs.tagdialog.close()"
                 class="fixed left-1/2 top-1/2 z-40 m-0 w-[40rem] max-w-[90%] -translate-x-1/2 -translate-y-1/2 transform overflow-visible rounded bg-sand p-0 opacity-0 transition backdrop:bg-black backdrop:bg-opacity-60 backdrop:backdrop-blur-lg open:opacity-100">
                 <form class="px-8 py-16 md:px-16" method="dialog">
                     <div class="mx-auto max-w-md">
                         <h3
                             class="type-xs-mono top-[45%] mb-6 origin-bottom whitespace-nowrap lg:absolute lg:right-full lg:block lg:translate-x-full lg:-rotate-90">
                             Filter by tag</h3>
                         <div class="grid gap-4 lg:grid-cols-3">
                             @foreach ($tags as $tag)
                                 <button wire:click="$set('selected_tag', '{{ $tag->name }}')"
                                     class="type-xs-mono group whitespace-nowrap rounded bg-sand-dark p-4 px-4 text-center transition hover:bg-yellow md:py-8">
                                     {{ $tag->name }}
                                 </button>
                             @endforeach
                         </div>

                         <button aria-label="Cancel" value="cancel"
                             class="type-xs-mono absolute left-1/2 top-full mt-4 flex -translate-x-1/2 flex-row items-center overflow-hidden rounded-full border border-black bg-black-light pr-4 !leading-none text-white transition hover:bg-black">
                             @svg('plus', 'rotate-45 w-9 h-9 p-2 mr-1 rounded-full bg-black block')
                             Close
                         </button>
                     </div>
                 </form>
             </dialog>

         @endif
     @endif

     <div class="relative ml-auto max-lg:flex-1 lg:w-64">
         <label for="post-search" class="sr-only">Search the journal</label>
         @svg('search', 'absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 pointer-events-none')
         <input id="post-search" type="search" wire:model.live.debounce.400ms="search" placeholder="Search"
             class="type-xs-mono w-full rounded bg-sand py-2 pl-8 pr-3 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-black lg:bg-sand-light" />
     </div>
 </div>
