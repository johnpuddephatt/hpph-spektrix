<div class="mb-32 divide-y divide-gray-light border-t border-gray-light">
    @foreach ($events as $event)
        <div class="flex flex-row gap-6 py-8">
            <a href="{{ route('event.show', ['event' => $event->slug]) }}"
                class="mb-auto aspect-video w-1/4 overflow-hidden rounded-lg bg-gray">
                @if ($event->featuredImage)
                    <x-image loading="lazy" class="block w-full" :src="$event->featuredImage->getUrl('wide')" :srcset="$event->featuredImage->getSrcset('wide')" />
                @endif
            </a>
            <a href="{{ route('event.show', ['event' => $event->slug]) }}" class="flex w-1/2 flex-col">

                <div class="mb-3">{{ $event->instance_dates }}</div>
                <h2 class="type-h5 mb-4">{{ $event->name }}</h2>
                <x-location color="text-yellow" :location="$event->venue" />

                <div class="mt-auto flex flex-row items-center gap-2 pt-2">
                    <x-certificate :certificate="$event->certificate_age_guidance" />
                    @foreach ($event->strands as $strand)
                        <x-strand :strand="$strand" />
                    @endforeach
                    <x-accessibilities :captioned="$event->has_captioned" :signedbsl="$event->has_signed_bsl" :audiodescribed="$event->has_audio_described" />
                    <x-genres-vibes-badge class="ml-2" :values="$event->genres_and_vibes" />
                </div>
            </a>
            <div class="flex w-1/4 flex-grow flex-col">
                @if ($event->description)
                    <p class="mb-auto overflow-hidden pb-4">
                        {{ Illuminate\Support\Str::limit($event->description, 120) }}</p>
                @endif
                <a class="type-subtitle mt-auto block rounded bg-gray py-2 px-4 text-center hover:bg-yellow hover:text-black"
                    href="{{ route('event.show', ['event' => $event->slug]) }}">More information &amp; tickets</a>
            </div>

        </div>
    @endforeach
</div>
