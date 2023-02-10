<div class="container divide-y divide-gray-light pt-3 pb-8">
    <div class="overflow-hidden">
        @php $events = $events->concat($events)->concat($events) @endphp
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 -mx-2 -mb-px">
            @foreach ($events as $event)
                <div class="border-gray-light pt-3 pb-12 border-b flex flex-col px-2">
                    <div class="type-xs-mono mb-3">{{ $event->instance_dates }}</div>
                    <a href="{{ route('event.show', ['event' => $event->slug]) }}"
                        class="mb-auto aspect-video overflow-hidden rounded">

                        <div class="relative aspect-video flex flex-col">
                            <div class="w-full relative flex-1 bg-gray rounded overflow-hidden">
                                @if ($event->featuredImage)
                                    <x-image width="100%" class="absolute inset-0" :src="$event->featuredImage->getUrl('wide')"
                                        :srcset="$event->featuredImage->getSrcset('wide')" />
                                @endif
                            </div>

                            <x-accessibilities class="absolute top-2 right-1.5" :dark="true" :captioned="$event->has_captioned"
                                :signedbsl="$event->has_signed_bsl" :audiodescribed="$event->has_audio_described" :specialevent="$event->has_special_event" />
                            @foreach ($event->strands as $strand)
                                <x-strand-badge class="mt-2" :strand="$strand" />
                            @endforeach
                        </div>
                    </a>
                    <a href="{{ route('event.show', ['event' => $event->slug]) }}" class="h-[5.5em]">
                        <h2 class="type-regular max-w-xs mt-4 mb-2">{{ $event->name }}
                            <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
                        </h2>
                    </a>

                    <div>
                        <button class="type-small inline-block py-0 bg-yellow text-black rounded-full px-2"
                            @click="$dispatch('booking', { eventID: '{{ $event->id }}', venue: '{{ $event->venue }}'  })">Book</button>
                        /
                        <a class="type-small inline-block py-0 bg-gray-dark text-white rounded-full px-2"
                            href="{{ $event->url }}">Info</a>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>
