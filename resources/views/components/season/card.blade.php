@props(['strand'])

@if ($season)
    <div class="container bg-black py-12">
        <div
            class="bg-black-light relative mx-auto flex flex-col lg:flex-row items-center text-white rounded overflow-hidden">
            <a href="{{ route('season.show', $season->slug) }}"
                class="group bg-black relative min-h-[16rem] my-0 lg:w-1/3 bg-opacity-50 self-stretch">

                @if ($season->featuredImage)
                    <div class="overflow-hidden">
                        {!! $season->featuredImage->img('landscape')->attributes(['class' => 'group-hover:scale-105 transition duration-500 w-full h-auto opacity-60']) !!}
                    </div>
                @endif

            </a>
            <div class="relative p-8 lg:pr-0 lg:py-4 lg:w-2/3 lg:pl-[16.67%]"">
                <div class="container">
                    <h3
                        class="type-xs-mono hidden lg:block text-white opacity-30 top-[45%] absolute right-full origin-bottom translate-x-full -rotate-90 transform whitespace-nowrap">
                        Strands &amp; seasons</h3>
                    <h3 class="type-regular lg:type-medium lg:mb-8 lg:!font-normal max-w-md">Part of <span
                            class="!font-bold text-yellow">{{ $season->name }}</span></h3>
                    <div class="type-regular max-w-lg !font-normal mb-16 lg:mb-8">{{ $season->description }}</div>
                    <a class="type-xs-mono before:absolute before:inset-0 text-white"
                        href="{{ route('season.show', $season->slug) }}">+
                        More from this season</a>
                </div>
            </div>
        </div>
    </div>
@endif
