<div class="bg-black pt-12 pb-16 text-white">
    <div class="container">
        <div class="type-xs-mono text-center mb-4">{{ $layout->title }}</div>
        <div class="type-regular lg:type-medium text-center"><span class="underline text-yellow">Upcoming</span> / <a
                class="hover:underline" href="{{ \App\Models\Page::getTemplateUrl('programme-page') }}">Full listings</a>
        </div>
        <x-instance-slider :instances="$layout->instances" layout="home" />
    </div>
</div>
