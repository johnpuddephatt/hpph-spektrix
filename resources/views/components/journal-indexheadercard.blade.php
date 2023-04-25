 @props(['post'])

 <a href="{{ $post->url }}" {{ $attributes->class(['flex', 'flex-col-reverse', 'lg:grid', 'lg:grid-cols-2']) }}>

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
             @svg('arrow-right', 'text-black h-10 w-10 p-2 lg:h-12 lg:w-12 lg:p-3 -rotate-45 rounded-full border border-black')
             <x-journal-postmeta :post="$post" />
         </div>
     </div>

     @if ($post->featuredImage)
         {!! $post->featuredImage->img('landscape', ['class' => 'w-full max-lg:object-cover max-lg:aspect-[1.2]'])->toHtml() !!}
     @else
         <div class="= aspect-video rounded bg-gray-light"></div>
     @endif
 </a>
