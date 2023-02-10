 @props(['post'])

 <a href="{{ $post->url }}" {{ $attributes->class(['flex', 'flex-col']) }}>
     @if ($post->image)
         <x-image class="rounded" :src="$post->image->src" :srcset="$post->image->srcset" />
     @else
         <div class="= aspect-video rounded bg-gray-light"></div>
     @endif

     <div class="">
         <h2 class="type-regular my-4">{{ $post->title }}</h2>
         <x-journal-postmeta :post="$post" />
     </div>
 </a>
