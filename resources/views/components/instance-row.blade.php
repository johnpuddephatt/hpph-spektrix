@props(['dark' => false, 'instance'])

<div {{ $attributes->class(['group cursor-default relative container transition duration-500']) }}>
    <div
        class="relative flex flex-row flex-wrap items-start border-b-[0.5px] border-gray-light py-4 lg:flex-nowrap lg:gap-6">

        <div class="relative flex aspect-video w-1/2 flex-col md:ml-[25%] md:w-1/4 lg:ml-0 lg:w-2/12">
            <div class="relative w-full flex-1 overflow-hidden rounded bg-sand-dark">
                @if ($instance->event->featuredImage)
                    {!! $instance->event->featuredImage->img('wide')->attributes([
                        'class' => 'group-hover:scale-105 transition duration-500 block w-full absolute max-w-none inset-0',
                        'loading' => 'lazy',
                    ]) !!}
                @endif
            </div>
            @if ($instance->strand?->show_on_instance_card)
                <x-strand.badge :dark="false" class="mt-2" :strand="$instance->strand" />
            @endif

        </div>

        <div class="flex w-1/2 flex-col items-start self-stretch pr-4 max-lg:-order-1 lg:w-4/12 lg:pr-0">
            <h4 class="type-regular mb-auto overflow-hidden text-ellipsis">
                <a class="before:absolute before:inset-0"
                    href="{{ route('event.show', ['event' => $instance->event->slug]) }}">
                    {{ $instance->event->name }}
                    <x-certificate class="align-middle" :dark="true" :certificate="$instance->event->certificate_age_guidance" />
                </a>
            </h4>

            @if ($instance->special_event || $instance->format)
                <div class="mt-2 lg:hidden">
                    <x-special-event-badge>{{ $instance->special_event }}</x-special-event-badge>
                    <x-special-event-badge>{{ $instance->format }}</x-special-event-badge>
                </div>
            @endif

            @if ($instance->event->subtitle)
                <p class="pt-2 leading-none">{{ $instance->event->subtitle }}</p>
            @endif
        </div>

        <div
            class="mt-4 flex flex-grow flex-row gap-2 self-stretch rounded-l-full bg-yellow p-1 pl-2.5 lg:mt-0 lg:w-4/12 lg:flex-grow-0 lg:flex-col lg:rounded-none lg:border-l lg:border-gray-light lg:bg-transparent lg:p-0 lg:pl-4">

            <div class="flex flex-row items-center gap-1.5">@svg('clock', ' flex-0 w-4 h-4')
                <div class="type-regular">{{ $instance->start->format('H:i') }}</div>
                @foreach ($instance->access_tags as $tag)
                    <x-accessibilities.badge :title="$tag->label">{{ $tag->abbreviation }}</x-accessibilities.badge>
                @endforeach
                @if (nova_get_setting('display_availability_badge', false))
                    <x-availability-badge :instance="$instance" />
                @endif
            </div>

            @if ($instance->special_event || $instance->format)
                <div class="mr-auto mt-auto hidden lg:block">
                    <x-special-event-badge>{{ $instance->special_event }}</x-special-event-badge>
                    <x-special-event-badge>{{ $instance->format }}</x-special-event-badge>
                </div>
            @endif
        </div>

        @if (!$instance->event->coming_soon)

            @if ($instance->external_ticket_link)
                <a target="_blank"
                    class="type-regular z-[1] mt-4 flex flex-row items-center justify-between rounded-r-full bg-yellow p-1 pl-4 after:absolute after:bottom-4 after:left-0 after:right-0 after:z-20 after:h-10 lg:mt-0 lg:w-2/12 lg:translate-x-1.5 lg:rounded-full lg:after:hidden hover:lg:bg-yellow-dark"
                    href="{{ $instance->external_ticket_link }}">Book
                    @svg('arrow-right', 'inline-block text-yellow p-2 ml-2 flex-shrink-0 h-7 w-7 bg-black rounded-full')</a>
            @else
                <button
                    class="type-regular z-[1] mt-4 flex flex-row items-center justify-between rounded-r-full bg-yellow p-1 pl-4 after:absolute after:bottom-4 after:left-0 after:right-0 after:z-20 after:h-10 lg:mt-0 lg:w-2/12 lg:translate-x-1.5 lg:rounded-full lg:after:hidden hover:lg:bg-yellow-dark"
                    @click='$dispatch("booking", { eventID: "{{ $instance->event->id }}", instanceID: "{{ $instance->short_id }}", event: {!! json_encode($instance->event->name) !!}, certificate: "{{ htmlentities($instance->event->certificate_age_guidance, ENT_QUOTES) }}" })'>Book
                    @svg('arrow-right', 'block text-yellow p-2 ml-2 flex-shrink-0 h-7 w-7 bg-black rounded-full')</button>
            @endif
        @endif
    </div>

</div>
