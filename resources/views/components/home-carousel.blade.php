 <div class="bg-yellow py-16 lg:py-32">
     <div class="container max-w-7xl text-center">
         <h2 class="type-h5 lg:type-h3">{{ $page->content->values_statement }} </h2>
     </div>
 </div>

 <div x-data="carousel" class="w-full overflow-hidden bg-yellow pb-16 lg:pb-36">
     <div :class="{ 'opacity-0': !initialised }" id="carousel-wrapper" x-intersect:enter="config.inView = true"
         x-intersect:leave="config.inView = false" @resize.window="init(); slideCarousel(config);"
         @scroll.window="slideCarousel(config)">
         <div class="images">
             @foreach ($page->content->values_images as $image)
                 <x-image :src="$image->src" :srcset="$image->srcset"
                     class="absolute left-0 block w-[66.667vw] origin-center rounded-[10em] lg:w-[50vw] xl:w-[33.3vw]" />
             @endforeach
         </div>
     </div>
 </div>
