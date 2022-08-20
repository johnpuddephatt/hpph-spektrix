<div class="flex flex-row" style="background-color: {{ $strand->color }}">
    <div class="relative lg:w-1/2">
        {!! $strand->featuredImage->img('landscape', ['class' => 'absolute inset-0 object-cover object-center w-full h-full'])->toHtml() !!}

        <div
            class="absolute top-1/2 left-1/2 z-10 flex w-1/2 -translate-x-1/2 -translate-y-1/2 transform justify-center">
            {!! $strand->logo !!}</div>
    </div>
    <div class="container py-16 px-12 lg:w-1/2">
        <div class="relative px-20">
            <div
                class="type-label absolute top-1/2 right-full origin-bottom translate-x-1/2 -rotate-90 transform whitespace-nowrap">
                Part of {{ $strand->name }}</div>
            <h3 class="type-h5 mb-8">{{ $strand->description }}</h3>
            <a href="{{ route('strand.show', $strand->slug) }}">Find out more about this strand @svg('right-chevron', 'inline-block h-4 w-4')</a>
        </div>
    </div>
</div>
