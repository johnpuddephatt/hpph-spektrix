<div x-trap="eventID" x-cloak
    @booking.window="eventID = $event.detail.eventID; instance = {short_id: $event.detail.instanceID}; event = $event.detail.event; certificate = $event.detail.certificate"
    @keyup.escape.window="closeBooking" x-data="{
        iFrameLoading: true,
        eventID: null,
        event: null,
        certificate: null,
        selectedInstance: null,
        showModal: true,
    
        instances: null,
    
        closeBooking() {
            this.eventID = null;
            this.selectedInstance = null;
            this.instances = null;
            $dispatch('booking', false)
        },
    
        getInstances(eventID) {
            if (!eventID) {
                return false;
            }
            fetch(`/api/event/${ this.eventID }/instances`)
                .then((response) => response.json())
                .then((json) => this.instances = json);
            console.log('instances', this.instances)
        },
    }"
    x-effect="
    if(instances === null && eventID) {
        getInstances(eventID);}
    ">

    <div x-show="eventID" x-on:click="closeBooking"
        class="fixed inset-0 z-30 bg-black bg-opacity-60 backdrop-blur-lg duration-150"
        x-transition:enter-start="opacity-0" x-transition:leave-end="opacity-0">
    </div>

    <div x-transition:enter-start="translate-y-full lg:translate-y-0 lg:translate-x-full"
        x-transition:leave="translate-y-full lg:translate-y-0 lg:translate-x-full" x-show="eventID"
        class="fixed bottom-0 right-0 top-0 z-50 flex h-screen w-full flex-col bg-sand transition lg:w-[90vw] xl:w-[75vw]">
        <button x-on:click="closeBooking" aria-label="Close booking options"
            class="absolute right-4 top-5 z-30 lg:right-full lg:top-[2.5rem] lg:mr-10">@svg('plus', 'h-6 w-6 text-black lg:text-white rotate-45 transform origin-center')</button>
        <h2 x-on:click="selectedInstance = null"
            class="type-regular lg:type-medium z-10 flex transform cursor-pointer flex-row items-center gap-4 whitespace-nowrap px-4 py-3 lg:absolute lg:right-full lg:w-[100vh] lg:origin-top-right lg:-rotate-90 lg:justify-between lg:p-10 lg:px-6 lg:text-right"
            :class="selectedInstance ? 'bg-yellow-dark cursor-pointer' : 'cursor-default bg-sand-dark lg:bg-sand'">
            <span>Showtimes</span> <span
                class="type-regular lg:type-medium order-first inline-block h-12 w-12 rounded-full bg-yellow py-3.5 text-center align-middle !leading-none lg:order-last lg:ml-4 lg:h-16 lg:w-16 lg:rotate-90 lg:py-5">1</span>
        </h2>
        <div class="container relative flex flex-grow flex-col overflow-y-auto pt-4 lg:pl-48 lg:pt-12" x-show="eventID">

            <div class="type-medium !font-normal">Select a showtime</div>

            <div x-show="instances === null" x-transition class="absolute inset-0 bg-sand py-16 pl-32">
                @svg('loading', 'w-32 ml-36 block pt-24 text-sand-dark')
            </div>

            <div x-show="instances && !instances.length" x-transition
                class="mt-4 max-w-md rounded bg-sand-light px-6 py-2 font-semibold">

                {!! $settings['no_scheduled_screenings'] ?? 'No scheduled screenings' !!}
            </div>

            <template x-if="instances && instances.length">
                <div class="flex flex-col gap-8 lg:flex-1 lg:flex-row lg:gap-12">
                    <div class="flex w-full max-w-xl flex-col lg:h-full">
                        <div class="mb-8 mt-1"><span class="font-bold" x-html="event"></span> <span
                                class="type-xs-mono inline-block min-w-[2em] rounded-full bg-gray-dark px-1 text-center align-middle text-white"
                                x-html="certificate"></span></div>

                        <div class="flex-1 pb-4 lg:pr-12">
                            <template x-for="(instance, key) in instances">
                                <div>
                                    <h3 x-show="key == 0 ||
                            instances[key - 1].start_date !== instance.start_date"
                                        class="type-small mb-3 mt-12" x-text="instance.start_date"></h3>
                                    <button aria-label="Buy tickets for this screening"
                                        x-on:click="instance.external_ticket_link ? (window.location.href = instance.external_ticket_link) : showModal = true; selectedInstance  = instance"
                                        :class="instances[key + 1]?.start_date !== instance.start_date ? 'border-b' : ''"
                                        class="group flex w-full flex-row items-center gap-2 border-t border-gray-light py-2 transition lg:gap-4">
                                        <div class="type-xs-mono rounded bg-black px-4 py-1.5 !text-base text-white"
                                            x-text="instance.start_time">
                                        </div>

                                        <div class="flex flex-col gap-x-2 gap-y-0.5 sm:flex-row sm:items-center">
                                            <x-strand.booking-path />

                                            <x-special-event-badge x-show="instance.special_event">
                                                <span x-text="instance.special_event"></span>
                                            </x-special-event-badge>

                                            <x-special-event-badge x-show="instance.format">
                                                <span x-text="instance.format"></span>
                                            </x-special-event-badge>

                                            <template x-for="tag in instance.access_tags">

                                                <x-accessibilities.badge ::title="tag.label">
                                                    <span x-text="tag.abbreviation"></span>
                                                </x-accessibilities.badge>
                                            </template>

                                        </div>

                                        <div class="ml-auto flex flex-row items-center gap-3">
                                            @if (nova_get_setting('display_availability_badge', false))
                                                <x-availability-badge />
                                            @endif

                                            @svg('arrow-right', 'bg-sand-light flex-shrink-0 group-hover:bg-yellow rounded-full p-3 h-12 w-12')
                                        </div>

                                    </button>
                                </div>
                            </template>

                            <div x-show="instances && !instances.length"
                                class="mt-12 max-w-md rounded bg-gray py-16 text-center">
                                {!! $settings['no_scheduled_screenings'] ?? 'No scheduled screenings' !!}
                            </div>
                        </div>

                    </div>
                    <div x-show="instances && instances.length && instances.some((instance) =>                         
                        {{ $access_tags->map(fn($tag) => $tag->slug ? "instance.{$tag->slug}" : null)->filter()->join(' || ') }}
                    )"
                        class="max-w-lg pb-8 lg:w-1/3 lg:max-w-xs lg:pt-[6.9rem] lg:text-center">
                        <h3 class="type-small mb-3">{{ $settings['access_key'] ?? 'Key' }}</h3>

                        @foreach ($access_tags as $tag)
                            <div x-show="{{ $tag->slug ? 'instances.some((instance) => instance.' . $tag->slug . ')' : 'false' }}"
                                class="border-t border-gray-light py-4 last:border-b">

                                <x-accessibilities.badge
                                    :title="$tag->name">{{ $tag->abbreviation }}</x-accessibilities.badge>
                                <p class="type-small mt-2 !font-normal">{{ $tag->description }}</p>

                            </div>
                        @endforeach

                        <p class="mt-6 underline"><a href="/access#accessible-screenings">Learn
                                about
                                accessible screenings</a></p>

                    </div>
                </div>
            </template>
        </div>
    </div>
    <div x-transition:enter-start="translate-y-full lg:translate-y-0 lg:translate-x-full"
        x-transition:leave="translate-y-full lg:translate-y-0 lg:translate-x-full"
        class="fixed bottom-0 right-0 top-[4.5rem] z-[60] flex w-full flex-col bg-sand transition lg:top-0 lg:min-h-screen lg:w-[calc(90vw-9rem)] xl:w-[calc(75vw-9rem)]"
        x-show="selectedInstance && eventID">

        {{-- <dialog
            x-show="showModal && ({{ $access_tags->map(fn($tag) => 'selectedInstance.' . $tag->slug . ' && ' . ($tag->booking_warning ? 'true' : 'false'))->join(' || ') }})"
            open>
            <div class="fixed inset-0 z-40 bg-black bg-opacity-60 backdrop-blur-lg duration-150"></div>
            <div
                class="fixed left-1/2 top-1/2 z-50 max-w-lg -translate-x-1/2 -translate-y-1/2 transform rounded bg-sand-light p-12">
                <h3 class="type-regular">Important information about your selected screening</h3>

                <div class="py-12">
                    @foreach ($access_tags as $tag)
                        <div x-show="selectedInstance.{{ $tag->slug }}  && {{ $tag->booking_warning ? 'true' : 'false' }}"
                            class="py-4 last:border-b">

                            <x-accessibilities.badge
                                :title="$tag->name">{{ $tag->abbreviation }}</x-accessibilities.badge>
                            <p class="type-small mt-2 !font-normal">{{ $tag->booking_warning }}</p>

                        </div>
                    @endforeach
                </div>
                <button class="type-small rounded bg-sand-dark px-4 py-2" @click="selectedInstance = null">Back</button>
                <button class="type-small rounded bg-yellow px-8 py-2" @click="showModal = false">Continue</button>
            </div>
        </dialog> --}}

        <h2
            class="type-regular lg:type-medium z-10 flex transform flex-row items-center gap-4 whitespace-nowrap bg-sand-dark px-4 py-3 lg:absolute lg:right-full lg:w-[100vh] lg:origin-top-right lg:-rotate-90 lg:justify-between lg:bg-transparent lg:p-10 lg:px-6 lg:text-right">
            <span>Tickets &amp; extras</span> <span
                class="type-regular lg:type-medium order-first inline-block h-12 w-12 rounded-full bg-yellow py-3.5 text-center align-middle !leading-none lg:order-last lg:ml-4 lg:h-16 lg:w-16 lg:rotate-90 lg:py-5">2</span>
        </h2>
        <div class="container relative flex-grow overflow-y-auto pt-4 lg:pl-40 lg:pt-12" x-show="selectedInstance">

            <template x-if="selectedInstance">
                <div class="flex flex-1 flex-col gap-8 lg:flex-row lg:gap-12">

                    <div class="w-full max-w-xl">
                        <div x-show="iFrameLoading" x-transition class="absolute inset-0 bg-sand py-12 lg:pl-32">
                            @svg('loading', 'w-32 mx-auto lg:ml-36 block pt-24 text-sand-dark')

                        </div>
                        <iframe x-on:load="iFrameLoading = false" class="w-full transition-all" id="SpektrixIFrame"
                            style="height: 90vh;" name="SpektrixIFrame"
                            :src="`https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/ChooseSeats.aspx?EventInstanceId=${ selectedInstance.short_id }&resize=true&stylesheet=hpph-spektrix-2.css`"></iframe>

                    </div>

                    <div class="-mt-8 max-w-lg pb-8 lg:mr-4 lg:mt-0 lg:w-1/3 lg:max-w-xs lg:pt-[8.9rem]">

                        <div class="mb-8">
                            <h3 class="type-small mb-3">Seating plan key</h3>
                            <div class="border-b border-t border-gray-light py-4">
                                <p class="type-xs"><span
                                        class="mr-1 inline-block h-4 w-4 translate-y-1/4 rounded-full bg-black"></span>
                                    Seat
                                    available
                                </p>
                                <p class="type-xs"><span
                                        class="mr-1 inline-block h-4 w-4 translate-y-1/4 rounded-full bg-[#b9b6b2]"></span>
                                    Seat
                                    unavailable
                                </p>
                                <p class="type-xs mt-0.5 flex items-center gap-1">
                                    <svg class="mr-0.5 h-auto w-4" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1"
                                        width="483.2226563" height="551.4306641" viewBox="0 0 483.2226563 551.4306641"
                                        overflow="visible" enable-background="new 0 0 483.2226563 551.4306641"
                                        xml:space="preserve">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M161.9882813,98.1240234  c24.9628906-2.3046875,44.3574219-23.8110352,44.3574219-48.9658203C206.3457031,22.0830078,184.2626953,0,157.1875,0  s-49.1572266,22.0830078-49.1572266,49.1582031c0,8.2568359,2.3037109,16.7055664,6.1445313,23.8105469l17.515625,246.4667969  l180.3964844,0.0488281l73.9912109,173.3652344l97.1445313-38.0976563l-15.0429688-35.8203125l-54.3662109,19.625  l-71.5908203-165.2802734l-167.7294922,1.1269531l-2.3027344-31.2128906l121.4228516,0.0483398v-46.1831055l-126.0546875-0.0493164  L161.9882813,98.1240234z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M343.4199219,451.5908203  c-30.4472656,60.1875-94.1748047,99.8398438-162.1503906,99.8398438C81.4296875,551.4306641,0,470.0009766,0,370.1611328  c0-70.1005859,42.4853516-135.2436523,105.8818359-164.1210938l4.1025391,53.5375977  c-37.4970703,23.628418-60.6123047,66.262207-60.6123047,110.9506836c0,72.4267578,59.0712891,131.4970703,131.4970703,131.4970703  c66.2617188,0,122.7646484-50.8515625,130.4697266-116.0869141L343.4199219,451.5908203z" />
                                    </svg>

                                    Wheelchair space

                                </p>
                            </div>
                        </div>

                        <h3 class="type-small mb-3">{{ $settings['members_basket_heading'] ?? 'Members' }}</h3>
                        <div class="type-xs prose border-t border-gray-light py-4 last:border-b">
                            {!! $settings['members_basket_text'] ??
                                'Please select a full-price ticket, any discounts will be applied at checkout after you have signed into your account' !!}
                        </div>
                    </div>
                </div>
            </template>
        </div>

    </div>

</div>
