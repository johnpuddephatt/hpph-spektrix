<div x-init="$dispatch('eventcount', { number: {{ $filtered ? $instances->count() : 0 }}, })">
    @foreach ($instances as $date => $events)
        <div>
            <div id="{{ Str::slug($events->first()->first()->start_date) }}"
                class="absolute left-0 right-0 h-[4.75rem] bg-sand-light lg:h-0"></div>
            <h3
                class="{{ $settings['alert_enabled'] && $settings['alert_display_until'] > now() ? 'top-4' : '-top-5' }} container sticky z-10 flex justify-center border-sand pb-1 pt-8 first:mt-0 lg:top-[6.95rem] lg:block lg:border-b lg:bg-sand-light">
                <a href="#{{ Str::slug($events->first()->first()->start_date) }}"
                    class="type-small inline-block rounded-full bg-yellow px-6 py-2.5">
                    {{ $events->first()->first()->start_date }}
                </a>
            </h3>
            <div>
                @foreach ($events as $eventId => $instances)
                    <div
                        class="group container relative flex flex-wrap items-start border-b-[1rem] border-sand-light py-4 last:border-b-0 lg:flex-row lg:flex-nowrap lg:gap-6">

                        <div class="relative flex aspect-video w-1/2 flex-col pr-4 lg:ml-0 lg:w-2/12 lg:pl-0 lg:pr-0">
                            <div class="relative w-full flex-1 overflow-hidden rounded bg-sand-dark">
                                @if ($instances->first()->event->featuredImage)
                                    {!! $instances->first()->event->featuredImage->img('wide')->attributes([
                                            'class' => 'group-hover:scale-105 transition duration-500 block w-full absolute max-w-none inset-0',
                                            'loading' => 'lazy',
                                        ]) !!}
                                @endif
                            </div>

                        </div>

                        <div class="flex w-1/2 flex-col items-start self-stretch lg:w-4/12">
                            <h4 class="type-regular mb-auto overflow-hidden text-ellipsis">
                                <a class="before:absolute before:inset-0"
                                    href="{{ route('event.show', ['event' => $instances->first()->event->slug]) }}">
                                    {{ $instances->first()->event->name }}
                                    <x-certificate class="align-middle" :dark="true" :certificate="$instances->first()->event->certificate_age_guidance" />
                                </a>
                            </h4>

                            @if ($instances->first()->event->subtitle)
                                <p class="pt-2 leading-none">{{ $instances->first()->event->subtitle }}</p>
                            @endif
                        </div>

                        <div
                            class="mt-4 flex flex-grow flex-col divide-y divide-gray-light self-stretch lg:mt-0 lg:w-4/12 lg:border-l lg:border-gray-light lg:pl-4">
                            @foreach ($instances as $instance)
                                <div class="flex flex-row items-start py-2 first:pt-0 lg:gap-2 lg:py-4">

                                    <div class="w-1/2 flex-none pr-4 lg:pr-0">

                                        @if ($instance->external_ticket_link)
                                            <a href="{{ $instance->external_ticket_link }}" target="_blank"
                                                class="type-mono relative block w-full rounded bg-black px-6 py-2 text-center text-white transition hover:bg-yellow hover:text-black">
                                                {{ $instance->start->format('H:i') }}</a>
                                        @else
                                            <button
                                                class="type-mono relative block w-full rounded bg-black px-6 py-2 text-center text-white transition hover:bg-yellow hover:text-black"
                                                @click="$event.stopPropagation(), $dispatch('booking', { eventID: '{{ $instance->event->id }}', instanceID: {{ $instance->short_id }}, event: '{{ htmlentities($instance->event->name, ENT_QUOTES) }}', certificate: '{{ htmlentities($instance->event->certificate_age_guidance, ENT_QUOTES) }}' })">
                                                {{ $instance->start->format('H:i') }}</button>
                                        @endif

                                    </div>

                                    <div class="flex flex-wrap items-start gap-1 lg:gap-2">
                                        @if (nova_get_setting('display_availability_badge', false))
                                            <x-availability-badge :instance="$instance" />
                                        @endif

                                        @if ($instance->strand)
                                            <x-strand.badge :dark="false" class="" :strand="$instance->strand" />
                                        @endif

                                        @if ($instance->format)
                                            <x-special-event-badge>{{ $instance->format }}</x-special-event-badge>
                                        @endif
                                        @if ($instance->special_event)
                                            <x-special-event-badge>{{ $instance->special_event }}</x-special-event-badge>
                                        @endif

                                        @foreach ($instance->access_tags as $tag)
                                            <x-accessibilities.badge
                                                :title="$tag->label">{{ $tag->abbreviation }}</x-accessibilities.badge>
                                        @endforeach

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    @endforeach
</div>
