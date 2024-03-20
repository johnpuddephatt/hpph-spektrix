@props(['event'])

<div class="group relative pt-4 pb-4 flex flex-col md:flex-row gap-4 lg:gap-6">

    <div class="w-1/2 md:w-1/4 lg:w-2/12 relative aspect-video flex flex-col">
        <div class="type-xs-mono max-md:bg-sand-light md:hidden max-md:container max-md:pt-3 pb-3">
            {!! $event->date_range !!}
        </div>
        <div class="w-full relative flex-1 bg-gray rounded overflow-hidden">
            @if ($event->featuredImage)
                {!! $event->featuredImage->img('wide')->attributes(['class' => 'group-hover:scale-105 transition duration-500 absolute inset-0']) !!}
            @endif
        </div>
        <x-accessibilities class="absolute top-2 right-1.5" :audiodescribed="$event->audio_description" />
        @if ($event->strand?->show_on_event_card)
            <x-strand.badge :partof="true" class="md:mt-2" :strand="$event->strand" />
        @endif
    </div>

    <div class="flex flex-col">
        <div class="type-xs-mono hidden md:block pb-2 pt-2">
            {!! $event->date_range !!}
        </div>
        <div class="lg:min-h-[4.5rem] mb-4 lg:mb-2">

            <h2 class="type-regular">{{ $event->name }}
                <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
            </h2>
            @if ($event->subtitle)
                <p class="pt-1 leading-none">{{ $event->subtitle }}</p>
            @endif

        </div>

        <div class="mt-auto"> <a
                class="type-small transition hover:text-sand-light hover:bg-gray-dark before:absolute before:inset-0 border-sand-light inline-block py-0 bg-sand-light rounded-full px-2"
                href="{{ $event->url }}">Info</a>
            @if (!$event->coming_soon)
                &nbsp;&nbsp; / &nbsp;&nbsp; <button
                    class="type-small border transition border-yellow hover:bg-black hover:text-yellow relative z-[1] inline-block py-0 bg-yellow text-black rounded-full px-2"
                    @click="$dispatch('booking', { eventID: '{{ $event->id }}', event: '{{ htmlentities($event->name, ENT_QUOTES) }}', certificate: '{{ htmlentities($event->certificate_age_guidance, ENT_QUOTES) }}'  })">Book</button>
            @endif
        </div>
    </div>

</div>
