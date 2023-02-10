 @props(['post'])

 <a href="{{ $post->url }}" {{ $attributes->class(['flex', 'flex-col-reverse', 'lg:grid', 'lg:grid-cols-2']) }}>

     <div class="container py-6 bg-sand-light flex flex-col h-full justify-center">
         <div class="mt-auto max-w-xs lg:max-w-md">
             <h2 class="type-regular lg:type-large mb-6">{{ $post->title }}</h2>
             <p>@todo Danielle Waters—film director, designer, illustrator—selects five films to mark the close of Black
                 History Month.</p>
         </div>

         <div class="mt-auto pt-8 flex flex-row-reverse justify-between lg:justify-start lg:flex-row items-center gap-6">
             @svg('arrow-right', 'text-black h-10 w-10 p-2 lg:h-12 lg:w-12 lg:p-3 -rotate-45 rounded-full border border-black')
             <x-journal-postmeta :post="$post" />
         </div>
     </div>

     @if ($post->image)
         <x-image class="w-full block" :src="$post->image->src" :srcset="$post->image->srcset" />
     @else
         <div class="aspect-[4/3] bg-sand-dark bg-opacity-50"></div>
     @endif
 </a>
