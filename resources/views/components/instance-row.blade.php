@props(['dark' => false, 'instance'])

<div {{ $attributes->class(['group cursor-default relative container transition duration-500']) }}>
    <div
        class="border-b-[0.5px] border-gray-light py-4 relative flex flex-wrap lg:flex-nowrap flex-row items-start lg:gap-6">

        @if ($instance->event->featuredImage)
            <div class="w-1/2 md:w-1/4 md:ml-[25%] lg:ml-0 lg:w-2/12 relative aspect-video flex flex-col">
                <div class="w-full relative flex-1 rounded overflow-hidden">
                    {!! $instance->event->featuredImage->img('wide')->attributes(['class' => 'group-hover:scale-105 transition duration-500 block w-full absolute max-w-none inset-0']) !!}
                </div>
                @if ($instance->strand?->show_on_instance_card)
                    <x-strand.badge :dark="false" class="mt-2" :strand="$instance->strand" />
                @endif
            </div>
        @endif

        <div class="max-lg:-order-1 flex w-1/2 pr-4 lg:pr-0 flex-col self-stretch items-start lg:w-4/12">
            <h4 class="type-regular mb-auto overflow-hidden text-ellipsis">
                <a class="before:absolute before:inset-0"
                    href="{{ route('event.show', ['event' => $instance->event->slug]) }}">
                    {{ $instance->event->name }}
                    <x-certificate class="align-middle" :dark="true" :certificate="$instance->event->certificate_age_guidance" />
                </a>
            </h4>

            <x-special-event-badge class="lg:hidden pt-2">{{ $instance->special_event }}</x-special-event-badge>

            @if ($instance->event->subtitle)
                <p class="pt-2 leading-none">{{ $instance->event->subtitle }}</p>
            @endif
        </div>

        <div
            class="bg-yellow lg:bg-transparent pl-2.5 rounded-l-full flex-grow lg:flex-grow-0 lg:rounded-none p-1 lg:p-0 mt-4 lg:mt-0 lg:border-l lg:border-gray-light lg:pl-4 flex flex-row gap-2 lg:flex-col self-stretch lg:w-4/12">

            <div class="flex flex-row items-center gap-1.5">@svg('clock', ' w-4 h-4')
                <div class="type-regular">{{ $instance->start->format('H:i') }}</div>
                <x-accessibilities :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->event->audio_description" :relaxed="$instance->relaxed" />
            </div>

            <div class="flex mt-auto mr-auto flex-row gap-2 items-center">
                <x-special-event-badge class="">{{ $instance->special_event }}</x-special-event-badge>
                @if ($instance->format)
                    <x-special-event-badge class="">{{ $instance->format }}</x-special-event-badge>
                @endif

            </div>
        </div>

        <button
            class="type-regular after:absolute lg:after:hidden after:z-20 after:bottom-4 after:left-0 after:right-0 after:h-10 z-[1] mt-4 lg:mt-0 lg:translate-x-1.5 justify-between pl-4 p-1 lg:w-2/12 bg-yellow hover:lg:bg-yellow-dark rounded-r-full lg:rounded-full items-center flex flex-row"
            @click="$dispatch('booking', { eventID: '{{ $instance->event->id }}', instanceID: '{{ $instance->short_id }}', event: '{{ htmlentities($instance->event->name, ENT_QUOTES) }}', certificate: '{{ htmlentities($instance->event->certificate_age_guidance, ENT_QUOTES) }}' })">Book
            @svg('arrow-right', 'block text-yellow p-2 ml-2 flex-shrink-0 h-7 w-7 bg-black rounded-full')</button>
    </div>

</div>
