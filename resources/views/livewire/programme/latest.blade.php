<div class="grid grid-cols-1 gap-y-16 gap-x-6 lg:grid-cols-2 2xl:grid-cols-3">
    @foreach ($events as $event)
        <div class="flex flex-col">
            <a href="{{ route('event.show', ['event' => $event->slug]) }}">
                <div class="mb-4 aspect-video overflow-hidden rounded-lg bg-gray">
                    @if ($event->featuredImage)
                        <x-image class="block w-full" :src="$event->featuredImage->getUrl('wide')" :srcset="$event->featuredImage->getSrcset('wide')" />
                    @endif
                </div>

                <div class="mb-3">{{ $event->instance_dates }}</div>
                <h2 class="type-h3 mb-12">{{ $event->name }}</h2>
            </a>

            <div class="space-between flex flex-row items-center gap-16 border-y border-gray py-2">

                <div class="flex w-1/2 flex-row items-center gap-2">
                    <x-certificate :certificate="$event->certificate_age_guidance" />
                    @foreach ($event->strands as $strand)
                        <x-strand :strand="$strand" />
                    @endforeach
                    <x-accessibilities :captioned="$event->has_captioned" :signedbsl="$event->has_signed_bsl" :audiodescribed="$event->has_audio_described" />
                </div>

                <x-location color="text-yellow" :location="$event->venue" />

            </div>
            <div class="mb-4 flex flex-grow flex-row gap-16">
                <div class="flex w-1/2 flex-col justify-end py-4">
                    @if ($event->description)
                        <div class="mb-auto overflow-hidden pb-4">
                            {!! $event->description !!}</div>
                    @endif
                    <x-genres-vibes-badge class="mt-auto" :values="$event->genres_and_vibes" />
                </div>
                <div class="flex-grow divide-y divide-gray">
                    @php
                        $current_date = null;
                        $date_count = 0;
                    @endphp
                    @foreach ($event->instances as $instance)
                        @if ($current_date !== $instance->start->format('dmy'))
                            @php($date_count++)
                            <div class="py-4">
                                <h3 class="type-label mb-1">
                                    @if ($instance->start->isToday())
                                        Today:
                                    @elseif($instance->start->isTomorrow())
                                        Tomorrow:
                                    @else
                                        {{ $instance->start->format('j F') }}:
                                    @endif
                                </h3>
                                <div class="flex flex-row gap-2">
                        @endif
                        <x-time :time="$instance->start->format('H:i')" />
                        @if ($current_date !== $instance->start->format('dmy'))
                </div>
            </div>
    @endif

    @php($current_date = $instance->date)
    @if ($date_count == 2)
    @break
@endif
@endforeach
</div>
</div>
<a class="type-subtitle mt-auto block rounded bg-yellow p-4 text-center hover:bg-black hover:text-yellow"
href="{{ route('event.show', ['event' => $event->slug]) }}">More information &amp; tickets</a>
</div>
@endforeach
</div>
