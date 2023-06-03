 @props(['post', 'dark' => false])

 <a href="{{ $post->url }}" {{ $attributes->class(['flex', 'flex-col', 'group']) }}>
     @if ($post->featuredImage)
         <div class="overflow-hidden">
             {!! $post->featuredImage->img('landscape', [
                     'id' => 'image-' . $post->id,
                     'class' => 'group-hover:scale-105 transition duration-500 w-full block rounded',
                 ])->toHtml() !!}
         </div>
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
