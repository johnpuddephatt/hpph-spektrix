@props(['dark' => false, 'instance'])

<div {{ $attributes->class(['cursor-default relative container transition duration-500']) }}>
    <div
        class="border-b-[0.5px] border-gray-light py-4 relative flex flex-wrap lg:flex-nowrap flex-row items-start lg:gap-6">

        @if ($instance->event->featuredImage)
            <div class="w-1/2 md:w-1/4 md:ml-[25%] lg:ml-0 lg:w-2/12">
                {!! $instance->event->featuredImage->img('wide')->attributes(['class' => 'w-full overflow-hidden rounded']) !!}
            </div>
        @endif

        <div class="max-lg:-order-1 flex w-1/2 pr-4 lg:pr-0 flex-col self-stretch items-start lg:w-4/12">
            <h4 class="type-regular overflow-hidden text-ellipsis">
                {{ $instance->event->name }}
                <x-certificate class="align-middle" :dark="true" :certificate="$instance->event->certificate_age_guidance" />
            </h4>
            <a class="type-small hidden lg:inline-block before:absolute before:inset-0 bg-sand-light mt-auto mb-2 px-4 rounded-full"
                href="{{ route('event.show', ['event' => $instance->event->slug]) }}">Info</a>
        </div>

        <div
            class="bg-yellow lg:bg-transparent pl-2.5 rounded-l-full flex-grow lg:flex-grow-0 lg:rounded-none p-1 lg:p-0 mt-4 lg:mt-0 lg:border-l lg:border-gray-light lg:pl-4 flex flex-row gap-2 lg:flex-col self-stretch lg:w-4/12">

            <div class="flex flex-row items-center gap-1.5">@svg('clock', ' w-4 h-4')
                <div class="type-regular">{{ $instance->start->format('H:i') }}</div>
                <x-accessibilities :dark="true" :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->audio_described" />
            </div>

            <div class="lg:mt-auto mr-auto lg:mb-2 flex flex-row gap-2 items-center">
                <x-strand.badge class="" :strand="$instance->strand" />
                <x-accessibilities :dark="false" :specialevent="$instance->special_event" />
            </div>
        </div>

        <button
            class="type-regular after:absolute lg:after:hidden after:z-20 after:bottom-4 after:left-0 after:right-0 after:h-10 z-[1] mt-4 lg:mt-0 lg:translate-x-1.5 justify-between pl-4 p-1 lg:w-2/12 bg-yellow hover:lg:bg-yellow-dark rounded-r-full lg:rounded-full items-center flex flex-row"
            @click="$dispatch('booking', { eventID: '{{ $instance->event->id }}', instanceID: '{{ $instance->short_id }}', event: '{{ $instance->event->name }}', certificate: '{{ $instance->event->certificate_age_guidance }}' })">Book
            @svg('arrow-right', 'block text-yellow p-2 ml-2 flex-shrink-0 h-7 w-7 bg-black rounded-full')</button>
    </div>

</div>
