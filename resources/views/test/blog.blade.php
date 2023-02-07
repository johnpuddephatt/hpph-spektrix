<div class="py-36 bg-gray-dark">
    <h1 class="text-5xl font-bold text-white text-center">{{ $title }}</h1>
    <p class="text-center text-xl mt-3 text-white">{{ $subtitle }}</p>
    <div class="max-w-7xl container mt-12 grid-cols-12 gap-10 grid">
        @foreach ($posts as $post)
            <div
                class="rounded-xl group relative flex flex-col items-start justify-end h-full overflow-hidden col-span-12 lg:col-span-4">
                @if ($post->featuredImage)
                    <img src="{{ $post->featuredImage->getUrl('landscape') }}" />
                @endif

                <div class="bg-white relative z-20 w-full h-auto py-8 text-black border-t-0 px-7">

                    <h2 class="mb-5 text-3xl font-bold"><a href="#_">{{ $post->title }}</a></h2>
                    <p class="text-purple-100 mb-2 text-lg font-normal opacity-100">
                        {{ $post->introduction }}
                    </p>

                </div>
            </div>
        @endforeach

    </div>
</div>
