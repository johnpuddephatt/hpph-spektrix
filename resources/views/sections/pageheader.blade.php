<div class="relative bg-black">
    @if ($page->mainImage && !($hide_image ?? false))
        {!! $page->mainImage->img('wide', ['class' => 'h-[100vw] lg:h-auto w-full opacity-80'])->toHtml() !!}
    @endif
    <h1
        class="type-medium lg:type-large container max-w-full text-center text-white absolute top-1/2 left-0 right-0 -translate-y-1/2">
        {{ $page->name }}
    </h1>
</div>
<div class="bg-yellow text-center pt-8 lg:pt-12 pb-16">
    <div class="type-xs-mono pb-12 lg:pb-8">{{ $page->subtitle }}</div>
    <div class="type-regular lg:type-medium container max-w-4xl text-center">{{ $page->introduction }}</div>
</div>
