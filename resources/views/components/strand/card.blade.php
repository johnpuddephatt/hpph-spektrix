@if ($strand)
    <div class="container bg-black py-12">
        <div class="bg-black-light mx-auto flex flex-col lg:flex-row items-center text-white rounded overflow-hidden">
            <a href="{{ route('strand.show', $strand->slug) }}"
                class="min-h-[18rem] bg-black relative my-0 lg:w-1/3 bg-opacity-50 self-stretch">

                @if ($strand->featuredImage)
                    {!! $strand->featuredImage->img('landscape')->attributes(['class' => 'w-full h-auto opacity-60']) !!}
                @endif

                @if ($strand->logo)
                    @icon($strand->logo, ' group-hover:delay-[0ms] delay-100 lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-72 max-w-full px-8')
                @else
                    <h3
                        class="type-regular lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-72 max-w-full px-8">
                        {{ $strand->name }}</h3>
                @endif
            </a>
            <div class="relative p-8 lg:pr-0 lg:py-4 lg:w-2/3 lg:pl-[16.67%]"">
                <div class="container">
                    <h3
                        class="type-xs-mono hidden lg:block text-white opacity-30 top-[45%] absolute right-full origin-bottom translate-x-full -rotate-90 transform whitespace-nowrap">
                        Strands &amp; seasons</h3>
                    <h3 class="type-regular lg:type-medium lg:mb-8 lg:!font-normal">Part of <span class="!font-bold"
                            style="color: {{ $strand->color }}">{{ $strand->name }}</span></h3>
                    <div class="type-regular max-w-lg !font-normal mb-16 lg:mb-8">{{ $strand->description }}</div>
                    <a class="type-xs-mono before:inset-0" style="color: {{ $strand->color }}"
                        href="{{ route('strand.show', $strand->slug) }}">+
                        More from this strand</a>
                </div>
            </div>
        </div>
    </div>
@endif
