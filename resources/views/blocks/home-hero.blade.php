<div class="mt-screen block w-screen overflow-hidden">

</div>

<div class="fixed inset-0 -z-10 h-screen w-full overflow-hidden border-b-[1rem] border-yellow bg-black">
    <figure
        class="max-w-[150vw] z-40 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-auto mx-auto w-[48rem]"
        x-data="{ animation: '' }" x-init="animation = lottie.loadAnimation({
            container: $el,
            renderer: 'svg',
            autoplay: true,
            loop: false,
            path: '{{ Storage::disk('public')->url($layout->animation) }}'
        })">
    </figure>

    @if ($layout->event)
        <div class="inset-0 absolute duration-[2000ms] opacity-0 delay-[3500ms]"
            x-bind:class="{ '!opacity-100': loaded }" x-data="{ loaded: false }" x-init="loaded = true">
            @if ($layout->event->featuredVideo)
                {!! $layout->event->featuredVideo->img('thumb', [
                    'id' => $layout->event->id,
                    'class' => '-z-10 w-full absolute opacity-70 h-full inset-0 object-cover',
                ]) !!}

                @if ($layout->event->featuredVideo->video_conversions)
                    @php($conversions = json_decode($layout->event->featuredVideo->video_conversions))
                    <div class="absolute inset-0 -z-10 h-full w-full bg-black opacity-0">
                        <video oncanplaythrough="setTimeout(() => { this.autoplay = true; this.play(); }, 3500)"
                            onplay="(function(e){e.parentNode.classList.remove('opacity-0');e.parentNode.classList.add('opacity-100');})(this)"
                            class="absolute inset-0 -z-10 h-full w-full object-cover opacity-70" playsinline muted loop>
                            @foreach ($conversions->{'1280x720'} as $format => $url)
                                <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                            @endforeach
                        </video>
                    </div>
                @endif
            @else
                {!! $layout->event->featuredImage->img('wide')->attributes(['class' => 'opacity-70 absolute inset-0 h-full w-full object-cover object-center lg:-z-10']) !!}
            @endif

            <div
                class="transform text-white h-auto justify-start flex text-left items-end flex-row gap-8 lg:gap-12 container absolute bottom-8 z-50">

                <a class="flex gap-2 flex-row items-center" href="{{ $layout->event->url }}">
                    @svg('arrow-right', 'inline-block rounded-full border rotate -rotate-45 p-2.5 h-9 w-9')

                    <h3 class="type-regular lg:max-w-xl max-w-xs">{{ $layout->event->name }}
                        <x-certificate :certificate="$layout->event->certificate_age_guidance" :dark="true" />
                    </h3>
                </a>

            </div>

        </div>
    @endif

</div>
