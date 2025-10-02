@if (count($layout->instances))
    <div class="bg-black pb-16 pt-12 text-white">
        <div class="container">
            <div class="type-xs-mono mb-4 text-center">{{ $layout->title }}</div>
            <div class="type-regular lg:type-medium mb-4 text-center">
                Now showing
            </div>
            <div class="text-center">
                <a class="type-small lg:type-regular text-yellow underline"
                    href="{{ \App\Models\Page::getTemplateUrl('programme-page') }}">See full
                    listings</a>
            </div>
            <x-instance-slider :entries="$layout->instances" layout="home" />
        </div>
    </div>
@endif
