@props(['event'])

<div class="group relative mb-4 flex flex-col border-gray-light px-2 pb-4 md:border-b md:pt-3">
    <div class="type-xs-mono pb-3 max-md:container max-md:bg-sand-light max-md:pt-3">
        {!! $event->date_range !!}
    </div>
    <div class="mb-auto aspect-video overflow-hidden md:rounded">
        <div class="relative flex aspect-video flex-col">
            <div class="relative w-full flex-1 overflow-hidden bg-gray md:rounded">
                @if ($event->featuredImage)
                    {!! $event->featuredImage->img('wide')->attributes(['class' => 'group-hover:scale-105 transition duration-500 absolute inset-0']) !!}
                @endif
            </div>
            @if ($event->audio_description)
                <x-accessibilities.badge class="absolute right-1.5 top-2" ::title="Audio description">AD</x-accessibilities.badge>
            @endif
            @if ($event->strand?->show_on_event_card)
                <x-strand.badge class="max-md:rounded-none max-md:px-4 max-md:py-2 max-md:text-left md:mt-2"
                    :partof="true" :strand="$event->strand" />
            @endif
        </div>
    </div>

    <div class="pb-4 max-md:container">
        <div class="mb-4 mt-4 lg:mb-2 lg:min-h-[4.5rem]">
            <h2 class="type-regular max-w-xs">{{ $event->name }}
                <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
            </h2>
            @if ($event->subtitle)
                <p class="pt-1 leading-none">{{ $event->subtitle }}</p>
            @endif

        </div>

        <div> <a class="type-small inline-block rounded-full border-sand-light bg-sand-light px-2 py-0 transition before:absolute before:inset-0 hover:bg-gray-dark hover:text-sand-light"
                href="{{ $event->url }}">Info</a>
            @if (!$event->coming_soon)
                &nbsp;&nbsp; / &nbsp;&nbsp; <button
                    class="type-small relative z-[1] inline-block rounded-full border border-yellow bg-yellow px-2 py-0 text-black transition hover:bg-black hover:text-yellow"
                    @click="$dispatch('booking', { eventID: '{{ $event->id }}', event: '{{ htmlentities($event->name, ENT_QUOTES) }}', certificate: '{{ htmlentities($event->certificate_age_guidance, ENT_QUOTES) }}'  })">Book</button>
            @endif
        </div>
    </div>

</div>
