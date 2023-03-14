    <div class="container bg-black pt-12 pb-24">
        <a href="{{ $layout->url }}"
            class="group bg-black-light mx-auto flex flex-col lg:flex-row items-center text-white rounded overflow-hidden">
            <div class="bg-black relative my-0 lg:w-1/3 bg-opacity-50 self-stretch">

                @if ($layout->banner)
                    <x-image class="w-full h-auto group-hover:opacity-80 transition opacity-60" width="30rem"
                        :src="Storage::url($layout->banner)" />
                @endif

                @if ($layout->logo)
                    @icon($layout->logo, ' group-hover:delay-[0ms] delay-100 lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-72 max-w-full px-8')
                @endif
            </div>
            <div class="relative p-8 lg:pr-0 lg:py-4 lg:w-2/3 lg:pl-[16.67%]"">
                @if ($layout->label)
                    <h3
                        class="type-xs-mono hidden lg:block text-white opacity-30 top-[45%] absolute right-full origin-bottom translate-x-full -rotate-90 transform whitespace-nowrap">
                        {{ $layout->label }}</h3>
                @endif
                <h3 class="type-regular strong-yellow lg:type-medium max-w-sm lg:mb-8 lg:!font-normal">
                    {!! Str::markdown($layout->title) !!}
                </h3>
                <div class="type-regular max-w-md !font-normal mb-16 lg:mb-8">{{ $layout->subtitle }}</div>
                <span class="type-xs-mono text-yellow">+
                    {{ $layout->link_text ?? 'Explore' }}</span>

            </div>
        </a>
    </div>
