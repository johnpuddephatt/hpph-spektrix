@props(['event'])

<div
    class="group relative mb-4 flex flex-col bg-sand px-2 pb-4 md:border-b md:border-gray-light md:bg-transparent md:pt-3">
    <div class="type-xs-mono pb-3 max-md:container max-md:pt-3">
        {!! $event->date_range !!}
    </div>
    <div class="-order-1 mb-auto aspect-video overflow-hidden md:order-none md:rounded">
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
        <div class="mb-4 md:mt-4 lg:mb-2 lg:min-h-[4.5rem]">
            <h2 class="type-regular max-w-xs">{{ $event->name }}
                <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
            </h2>
            @if ($event->subtitle)
                <p class="pt-1 leading-none">{{ $event->subtitle }}</p>
            @endif

        </div>

        <div class="space-x-1">
            <a class="type-body inline-block rounded border-sand-light bg-sand-light px-6 py-1 !font-bold transition before:absolute before:inset-0 hover:bg-gray-dark hover:text-sand-light"
                href="{{ $event->url }}">Info</a>
            @if (!$event->coming_soon)
                <button
                    class="type-body relative z-[1] inline-block rounded border border-yellow bg-yellow px-6 py-1 !font-bold text-black transition hover:bg-black hover:text-yellow"
                    @click="$dispatch('booking', { eventID: '{{ $event->id }}', event: '{{ htmlentities($event->name, ENT_QUOTES) }}', certificate: '{{ htmlentities($event->certificate_age_guidance, ENT_QUOTES) }}'  })">Book</button>
            @endif
        </div>
    </div>

</div>
