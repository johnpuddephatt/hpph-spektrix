<div
    class="{{ $layout->background_colour }} {{ $layout->background_colour == 'bg-black' ? 'border-b border-black-light text-white' : null }} container py-16">
    <div
        class="{{ $layout->title ? 'grid lg:grid-cols-2 gap-4' : 'mx-auto max-w-xl' }} {{ $layout->is_centered ? 'text-center' : '' }}">
        <div class="">
            @if ($layout->title)
                <h2 id="{{ $layout->slug ?? Str::slug($layout->title) }}"
                    class="type-medium {{ $layout->heading_colour }}">
                    <a href="#{{ $layout->slug ?? Str::slug($layout->title) }}">
                        {{ $layout->title }}
                    </a>
                </h2>
            @endif

            @if ($layout->subtitle)
                <h3 class="type-regular mb-8 mt-4 max-w-[39ch]">

                    {{ $layout->subtitle }}
                </h3>
            @endif
        </div>

        <x-editorjs class="prose" :content="$layout->section_content" block_class="" />

    </div>
</div>
