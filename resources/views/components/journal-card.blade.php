 @props(['post', 'dark' => false])

 <a href="{{ $post->url }}" {{ $attributes->class(['flex', 'flex-col']) }}>
     @if ($post->image)
         <x-image class="block w-full rounded" :src="$post->image->src" :srcset="$post->image->srcset" />
     @else
         <div class="{{ $dark ? 'bg-gray-dark' : 'bg-gray-light' }} aspect-video rounded"></div>
     @endif

     <div class="{{ $dark ? 'text-white' : 'text-black' }} min-h-[4.5em]">
         <h2 class="type-regular my-4">{{ $post->title }}</h2>
         @if ($post->subtitle)
             <p class="type-regular !font-normal -mt-4 mb-2">{{ $post->subtitle }}</p>
         @endif

     </div>
     <x-journal-postmeta :post="$post" :dark="$dark" />
 </a>
