<div class="container bg-black pt-12">
    <div class="bg-black-light mx-auto flex flex-row items-center text-white rounded overflow-hidden">
        <div class="bg-black relative my-0 lg:w-1/3 bg-opacity-50 self-stretch">

            @if ($strand->featuredImage)
                <x-image class="w-full h-auto" width="30rem" :src="$strand->featuredImage->getUrl('landscape')" :srcset="$strand->featuredImage->getSrcset('landscape')" />
            @endif

            @if ($strand->logo)
                @icon($strand->logo, ' group-hover:delay-[0ms] delay-100 lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-72 max-w-full px-8')
            @else
                <h3
                    class="type-h4 lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-72 max-w-full px-8">
                    {{ $strand->name }}</h3>
            @endif
        </div>
        <div class="relative py-12 lg:w-1/2 pl-[16.67%]"">

            <h3
                class="type-xs-mono text-white opacity-30 top-[45%] absolute right-full origin-bottom translate-x-full -rotate-90 transform whitespace-nowrap">
                Strands &amp; seasons</h3>
            <h3 class="type-medium mb-8 !font-normal">Part of <span class="!font-bold"
                    style="color: {{ $strand->color }}">{{ $strand->name }}</span></h3>
            <div class="type-regular !font-normal mb-8 max-w-xl">{{ $strand->description }}</div>
            <a class="type-xs-mono" style="color: {{ $strand->color }}"
                href="{{ route('strand.show', $strand->slug) }}">+
                More from this strand</a>

        </div>
    </div>
</div>
