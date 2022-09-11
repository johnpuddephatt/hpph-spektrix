 <div
     class="{{ $banner->height }} {{ $banner->text_color }} {{ $banner->bg_color }} relative flex flex-col items-center justify-center py-32">
     <x-image :src="$banner->src" :srcset="$banner->srcset" class="absolute inset-0 h-full w-full object-cover" />
     {{ $banner->src }}
     {{ $banner->srcset }}
     @if ($banner->overlay)
         <div class="absolute inset-0 bg-black bg-opacity-50"></div>
     @endif
     <div class="container relative">
         <div class="w-2/3 lg:w-2/5">
             <h2 class="type-h2 mb-8">{{ $banner->title }}</h2>
             <p class="type-large">{{ $banner->subtitle }}</p>
             <div class="mt-8 w-12 rounded-full bg-yellow text-black">
                 @svg('right-chevron', 'w-full h-auto p-0.5')
             </div>
         </div>
     </div>
 </div>
