  <div class="h-screen flex flex-col relative border-b-8 border-yellow bg-black">

      @if ($page->mainImage && !($hide_image ?? false))
          {!! $page->mainImage->img('wide', ['class' => 'absolute w-full opacity-60 inset-0 h-full object-cover'])->toHtml() !!}
      @endif

      <div class="text-white relative container lg:w-1/2 lg:mr-0 mt-auto">
          <h1 class="type-medium lg:type-large">{{ $page->name }}</h1>
          <p class="type-xs-mono mt-2 lg:mt-4">{{ $page->subtitle }}</p>
      </div>

      <div class="relative bg-yellow mt-8 lg:mt-auto container lg:w-1/2 mr-0">
          <div class="type-medium py-8 lg:py-16 max-w-xl">
              {{ $page->introduction }}
          </div>
          <a href="#page-content">@svg('chevron-down', 'h-10 w-10 text-black')</a>
      </div>
  </div>
  <div id="page-content"></div>
