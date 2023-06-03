@props(['event'])

<div class="group border-gray-light relative md:pt-3 mb-4 pb-4 md:border-b flex flex-col px-2">
    <div class="type-xs-mono max-md:bg-sand-light max-md:container max-md:pt-3 pb-3">
        {!! $event->date_range !!}
    </div>
    <div class="mb-auto aspect-video overflow-hidden md:rounded">
        <div class="relative aspect-video flex flex-col">
            <div class="w-full relative flex-1 bg-gray md:rounded overflow-hidden">
                @if ($event->featuredImage)
                    {!! $event->featuredImage->img('wide')->attributes(['class' => 'group-hover:scale-105 transition duration-500 absolute inset-0']) !!}
                @endif
            </div>
            <x-accessibilities class="absolute top-2 right-1.5" :audiodescribed="$event->audio_description" />
            @if ($event->strand?->show_on_event_card)
                <x-strand.badge class="max-md:rounded-none md:mt-2" :strand="$event->strand" />
            @endif
        </div>
    </div>

    <div class="max-md:container md:bg-transparent bg-sand-light pb-4">
        <div class="lg:min-h-[4.5rem] mt-4 mb-4 lg:mb-2">
            <h2 class="type-regular max-w-xs">{{ $event->name }}
                <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
            </h2>
            @if ($event->subtitle)
                <p class="pt-1 leading-none">{{ $event->subtitle }}</p>
            @endif
            <x-special-event-badge class="max-lg:bg-white mt-2">{{ $event->has_special_event }}
            </x-special-event-badge>
        </div>

        <div> <a class="type-small border:sand hover:text-sand-light hover:bg-gray-dark before:absolute before:inset-0 lg:border-sand-light inline-block py-0 bg-sand lg:bg-sand-light rounded-full px-2"
                href="{{ $event->url }}">Info</a> &nbsp;&nbsp; / &nbsp;&nbsp; <button
                class="type-small border border-yellow hover:bg-black hover:text-yellow relative z-[1] inline-block py-0 bg-yellow text-black rounded-full px-2"
                @click="$dispatch('booking', { eventID: '{{ $event->id }}', event: '{{ $event->name }}', certificate: '{{ $event->certificate_age_guidance }}'  })">Book</button>
        </div>
    </div>

</div>
