 @if ($page->mainImage && !($hide_image ?? false))
     {!! $page->mainImage->img('wide', ['class' => 'w-full'])->toHtml() !!}
 @endif
 <div class="bg-sand pt-16 pb-24">
     <div class="grid lg:grid-cols-2">
         <h1 class="type-large container">{{ $page->name }}</h1>
         <p class="type-medium container mt-8 ml-0 max-w-2xl lg:mt-0">{{ $page->introduction }}</p>
     </div>
 </div>
