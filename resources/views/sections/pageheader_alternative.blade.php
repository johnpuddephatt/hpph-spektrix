<div class="grid grid-cols-2">
    <div class="bg-sand-light container flex flex-col justify-center">
        <div class="type-medium lg:type-large max-w-lg pb-12 lg:pb-8">{{ $page->name }}</div>
        <div class="max-w-lg">{{ $page->introduction }}</div>
    </div>
    @if ($page->mainImage && !($hide_image ?? false))
        {!! $page->mainImage->img('landscape', ['class' => 'w-full'])->toHtml() !!}
    @endif
</div>
