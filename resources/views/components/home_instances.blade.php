 <div class="bg-black py-12 text-white">
     <div class="container">
         <livewire:programme.instances :options="$page->content->instance_options" :dark="true" />
         <div class="type-subtitle lg:type-h5">See <a class="text-yellow underline" href="{{ route('programme') }}">full
                 listings
                 @svg('right-chevron', 'h-9 w-9 text-white inline-block')
             </a>
         </div>
     </div>
 </div>
