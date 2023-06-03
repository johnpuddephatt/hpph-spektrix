 @props(['post'])

 <a href="{{ $post->url }}"
     {{ $attributes->class(['group', 'flex', 'flex-col-reverse', 'lg:grid', 'lg:grid-cols-2']) }}>

     <div class="container py-6 bg-sand-light flex flex-col h-full justify-center">
         <div class="md:pt-12 mt-auto max-w-xs sm:max-w-md xl:max-w-lg 2xl:max-w-xl">
             <h2 class="type-regular lg:type-medium xl:type-large mb-6">{{ $post->title }}</h2>
             @if ($post->subtitle)
                 <p class="type-regular xl:type-medium !font-normal -mt-6 mb-6">{{ $post->subtitle }}</p>
             @endif
             <p>{{ $post->introduction }}</p>
         </div>

         <div
             class="mt-auto pt-8 lg:pt-0 flex flex-row-reverse justify-between lg:justify-start lg:flex-row items-center gap-6">
             @svg('arrow-right', 'group-hover:text-yellow group-hover:border-yellow transition text-black h-10 w-10 p-2 lg:h-12 lg:w-12 lg:p-3 rounded-full border border-black')
             <x-journal-postmeta :post="$post" />
         </div>
     </div>

     @if ($post->featuredImage)
         <div class="overflow-hidden">
             {!! $post->featuredImage->img('landscape', [
                     'class' => 'group-hover:scale-105 transition duration-500 w-full max-md:object-cover max-md:aspect-[1.2]',
                 ])->toHtml() !!}
         </div>
     @else
         <div class="aspect-video rounded bg-gray-light"></div>
     @endif
 </a>
