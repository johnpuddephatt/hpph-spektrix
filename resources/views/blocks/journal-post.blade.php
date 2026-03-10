@if ($layout->post)

    <div class="@if ($layout->dark) bg-black @else bg-sand-dark @endif relative py-16">
        @if ($layout->striped)
            <div class="absolute inset-0 h-1/2 bg-black"></div>
        @endif
        <div class="{{ $layout->narrow ? 'max-w-5xl' : 'max-w-8xl' }} container relative">
            @if ($layout->title)
                <h2 class="type-xs-mono {{ $layout->dark ? 'text-white' : '' }} mb-4 text-center">
                    {{ $layout->title }}
                </h2>
            @endif
            <a href="{{ $layout->post->url }}"
                class="{{ $layout->dark ? 'bg-black-light text-white' : 'bg-sand' }} group block flex-col items-center overflow-hidden rounded lg:flex lg:flex-row">
                @if ($layout->post->featuredImage)
                    <div class="w-full self-stretch overflow-hidden lg:w-1/2">
                        {!! $layout->post->featuredImage->img('wide')->attributes([
                            'class' => 'h-full group-hover:scale-105 transition duration-500  block  object-cover aspect-video lg:aspect-auto',
                        ]) !!}
                    </div>
                @endif

                <div class="mx-auto flex aspect-video flex-col p-8 sm:aspect-auto lg:block lg:w-1/2 lg:max-w-md lg:py-8">
                    <div class="lg:min-h-[9rem]">
                        <h2 class="type-regular lg:type-medium">{{ $layout->post->title }}</h2>
                        @if ($layout->post->subtitle)
                            <p class="type-regular lg:type-medium mb-4 !font-normal">{{ $layout->post->subtitle }}</p>
                        @elseif($layout->post->summary)
                            <p class="type-small mb-4 mt-4 !font-normal">{{ $layout->post->summary }}</p>
                        @endif

                    </div>

                    <div class="mt-auto flex flex-row justify-between gap-4 pt-2 align-bottom">

                        <x-journal-postmeta :post="$layout->post" :dark="$layout->dark" />

                        @svg('arrow-right', 'rounded-full border rotate p-2.5 h-9 w-9')
                    </div>
                </div>
            </a>
        </div>
    </div>
@endif
