<div class="mt-screen pointer-events-none block w-screen overflow-hidden">

</div>

<div class="fixed inset-0 h-screen w-full overflow-hidden border-b-[1rem] border-yellow bg-black">
    <figure
        class="absolute left-1/2 top-1/2 z-40 mx-auto h-auto w-[48rem] max-w-[150vw] -translate-x-1/2 -translate-y-1/2"
        x-data="{ animation: '' }" x-init="animation = lottie.loadAnimation({
            container: $el,
            renderer: 'svg',
            autoplay: true,
            loop: false,
            path: '{{ Storage::disk('public')->url($layout->animation) }}'
        })">
    </figure>

    @if ($layout->event)
        @php($event = $layout->event)

        {{-- previously had delay-[3500ms] on it, to bring video in after the animation finishes. --}}
        <div class="absolute inset-0 opacity-0 delay-500 duration-[2000ms]" x-bind:class="{ '!opacity-100': loaded }"
            x-data="{ loaded: false }" x-init="loaded = true">

            @if ($event->featuredVideo)
                {!! $event->featuredVideo->img('thumb', [
                    'id' => $event->id,
                    'class' => '-z-10 w-full absolute opacity-70 h-full inset-0 object-cover',
                ]) !!}

                @if ($event->featuredVideo->video_conversions)
                    @php($conversions = json_decode($event->featuredVideo->video_conversions))
                    <div class="absolute inset-0 -z-10 h-full w-full bg-black opacity-0">
                        <video
                            onplay="(function(e){e.parentNode.classList.remove('opacity-0');e.parentNode.classList.add('opacity-100'); setTimeout(()=>{ e.currentTime = 0 },3500)})(this)"
                            class="absolute inset-0 -z-10 h-full w-full object-cover opacity-70" autoplay playsinline
                            muted loop>
                            @foreach ($conversions->{'1280x720'} as $format => $url)
                                <source src="{{ Storage::url($url) }}" type="video/{{ $format }}">
                            @endforeach
                        </video>
                    </div>
                @endif
            @elseif($event->featuredImage)
                {!! $event->featuredImage->img('wide')->attributes(['class' => 'opacity-70 absolute inset-0 h-full w-full object-cover object-center lg:-z-10']) !!}
            @endif

            <div
                class="{{ $settings['alert_enabled'] && $settings['alert_display_until'] > now() ? 'bottom-16' : 'bottom-4' }} container absolute z-50 flex h-auto transform flex-row items-end justify-start gap-8 text-left text-white lg:bottom-8 lg:gap-12">

                <a class="flex flex-row items-center gap-2" href="{{ $event->url }}">
                    @svg('arrow-right', 'inline-block rounded-full text-white bg-black rotate p-3 h-10 w-10')

                    <h3 class="type-regular max-w-xs lg:max-w-xl">{{ $event->name }}
                        <x-certificate :certificate="$event->certificate_age_guidance" :dark="false" />
                    </h3>
                </a>

            </div>

        </div>
    @endif

</div>
