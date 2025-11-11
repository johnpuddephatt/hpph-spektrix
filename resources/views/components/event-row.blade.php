@props(['event'])

<div class="group relative flex flex-col gap-4 pb-4 pt-4 md:flex-row lg:gap-6">

    <div class="relative flex aspect-video w-full flex-col md:w-1/4 lg:w-2/12">
        <div class="type-xs-mono py-2 max-md:container max-md:bg-sand-light md:hidden">
            {!! $event->date_range !!}
        </div>
        <div class="relative w-full flex-1 overflow-hidden bg-gray md:rounded">
            @if ($event->featuredImage)
                {!! $event->featuredImage->img('wide')->attributes(['class' => 'group-hover:scale-105 transition duration-500 absolute inset-0']) !!}
            @endif
        </div>

        @if ($event->audio_description)
            <x-accessibilities.badge class="absolute right-1.5 top-2" ::title="Audio description">AD</x-accessibilities.badge>
        @endif
        @if ($event->strand?->show_on_event_card)
            <x-strand.badge :partof="true" class="md:mt-2" :strand="$event->strand" />
        @endif
    </div>

    <div class="flex flex-col max-md:container">
        <div class="type-xs-mono hidden pb-2 pt-2 md:block">
            {!! $event->date_range !!}
        </div>
        <div class="mb-4 lg:mb-2 lg:min-h-[4.5rem]">

            <h2 class="type-regular">{{ $event->name }}
                <x-certificate :dark="true" :certificate="$event->certificate_age_guidance" />
            </h2>
            @if ($event->subtitle)
                <p class="pt-1 leading-none">{{ $event->subtitle }}</p>
            @endif

        </div>

        <div class="mt-auto space-x-1">
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
