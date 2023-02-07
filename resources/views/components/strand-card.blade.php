<div class="bg-black-light flex flex-row items-center text-white">
    <div class="bg-black relative my-0 lg:w-1/3 bg-opacity-50 self-stretch">
        @if ($strand->featuredImage)
            {!! $strand->featuredImage->img('landscape', ['class' => 'absolute inset-0 object-cover object-center w-full h-full'])->toHtml() !!}
        @endif
        <div
            class="absolute top-1/2 left-1/2 z-10 flex w-1/2 max-w-xs -translate-x-1/2 -translate-y-1/2 transform justify-center">
            {!! $strand->logo !!}</div>
    </div>
    <div class="relative py-12 lg:w-1/2 pl-[16.67%]"">

        <h3
            class="type-xs-mono text-white opacity-30 top-[45%] absolute right-full origin-bottom translate-x-full -rotate-90 transform whitespace-nowrap">
            Strands &amp; seasons</h3>
        <h3 class="type-medium mb-8 !font-normal">Part of <span class="!font-bold"
                style="color: {{ $strand->color }}">{{ $strand->name }}</span></h3>
        <div class="type-regular !font-normal mb-8 max-w-xl">{{ $strand->description }}</div>
        <a class="type-xs-mono" style="color: {{ $strand->color }}" href="{{ route('strand.show', $strand->slug) }}">+
            More from this strand</a>

    </div>
</div>
