@props(['season', 'total_slides' => 1])
@if ($season)

    <a href="{{ route('season.show', $season->slug) }}"
        class="{{ $total_slides == 2 ? 'mt-8' : '' }} {{ $total_slides < 3 ? 'lg:flex-row gap-3 lg:gap-4 lg:bg-black-light' : null }} group mx-auto flex flex-col lg:items-center text-white rounded overflow-hidden">
        <div class="{{ $total_slides < 3 ? 'lg:hidden' : ' mb-6' }} type-xs-mono self-start text-white">Strands &amp;
            seasons
        </div>

        <div
            class="{{ $total_slides == 2 ? 'lg:w-1/2 rounded lg:rounded-none' : '' }} {{ $total_slides == 1 ? 'lg:w-1/3 h-[18rem]' : 'aspect-video' }} bg-black overflow-hidden rounded-t relative my-0 bg-opacity-50 self-stretch">
            @if ($season->featuredImage)
                <div class="overflow-hidden">
                    {!! $season->featuredImage->img('landscape')->attributes([
                        'class' =>
                            'group-hover:scale-105  transition duration-500 absolute w-full h-full object-cover opacity-60 group-hover:opacity-80',
                    ]) !!}
                </div>
            @endif
                {{-- <h3
                    class="type-regular lg:group-hover:opacity-0 lg:group-hover:-translate-y-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 mx-auto w-72 max-w-full px-8">
                    {{ $season->name }}</h3> --}}
        </div>
        <div
            class="{{ $total_slides == 3 ? '' : null }} {{ $total_slides == 1 ? ' lg:w-2/3 lg:pl-[16.67%] lg:px-8' : null }} {{ $total_slides == 2 ? 'xl:pl-6' : null }} {{ $total_slides < 3 ? 'lg:w-1/2  py-2 xl:py-8 lg:py-2' : 'py-6 bg-black-light w-full' }} relative lg:pr-0">
            <div class="{{ $total_slides == 2 ? 'px-4 lg:pl-0 lg:pr-2 xl:px-4' : null }} container">
                <h3
                    class="{{ $total_slides < 3 ? 'xl:block' : null }} type-xs-mono left-0 origin-center top-1/2 -rotate-90 -translate-x-1/2 -translate-y-1/2 absolute hidden opacity-30 text-white transform whitespace-nowrap">
                    Strands &amp; seasons</h3>
                <h3
                    class="{{ $total_slides == 1 ? ' lg:type-medium mb-4 lg:mb-8  lg:!font-normal' : 'mb-1' }} type-regular {{ $total_slides == 2 ? '2xl:type-medium' : null }}">
                    Part of <span class="!font-bold text-yellow" >{{ $season->name }}</span>
                </h3>
                <div
                    class="{{ $total_slides == 1 ? 'mb-16 lg:mb-8  type-regular' : 'type-small mb-2' }} {{ $total_slides == 2 ? ' 2xl:type-regular' : '' }} max-w-lg !font-normal">
                    {{ $season->description }}</div>
                <span class="type-xs-mono group-hover:underline before:inset-0 text-yellow">+
                    More from this season</span>
            </div>
        </div>
    </a>

@endif
