<div
    class="{{ $layout->background_colour }} {{ $layout->background_colour == 'bg-black' ? 'text-white' : null }} py-16 container">
    <div
        class="{{ $layout->title ? 'grid lg:grid-cols-2 gap-4' : 'mx-auto max-w-xl' }} {{ $layout->is_centered ? 'text-center' : '' }}">
        <div class="">
            @if ($layout->title)
                <h2 class="type-medium {{ $layout->heading_colour }}">
                    {{ $layout->title }}</h2>
            @endif
        </div>

        {{-- <x-editordotjs class="prose" :content="$layout->section_content" block_class="" /> --}}

        <x-editorjs class="prose" :content="$layout->section_content" block_class="" />

    </div>
</div>
