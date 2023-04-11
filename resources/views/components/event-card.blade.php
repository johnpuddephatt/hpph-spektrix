@props(['event'])

<div class="border-gray-light relative md:pt-3 pb-8 md:pb-12 md:border-b flex flex-col px-2">
    <div class="type-xs-mono max-md:bg-sand-light max-md:container max-md:pt-3 pb-3">
        {!! $event->date_range !!}
    </div>
    <div class="mb-auto aspect-video overflow-hidden md:rounded">
        <div class="relative aspect-video flex flex-col">
            <div class="w-full relative flex-1 bg-gray md:rounded overflow-hidden">
                @if ($event->featuredImage)
                    {!! $event->featuredImage->img('wide')->attributes(['class' => 'absolute inset-0']) !!}
                @endif
            </div>

            <x-accessibilities class="absolute top-2 right-1.5" :dark="true" :captioned="$event->has_captioned" :signedbsl="$event->has_signed_bsl"
                :audiodescribed="$event->has_audio_described" :specialevent="$event->has_special_event" />
            <x-strand.badge class="max-md:rounded-none md:mt-2" :strand="$event->strand" />
        </div>
    </div>

    <div class="max-md:container">
        <h2 class="type-regular lg:h-[4rem] max-w-xs mt-4 mb-4 lg:mb-2">{{ $event->name }}
            <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
        </h2>

        <div>
            <a class="type-small before:absolute before:inset-0 inline-block py-0 bg-gray-dark text-white rounded-full px-2"
                href="{{ $event->url }}">Info</a> / <button
                class="type-small relative z-[1] inline-block py-0 bg-yellow text-black rounded-full px-2"
                @click="$dispatch('booking', { eventID: '{{ $event->id }}', event: '{{ $event->name }}', certificate: '{{ $event->certificate_age_guidance }}'  })">Book</button>
        </div>
    </div>

</div>
