<div x-trap="eventID" x-cloak
    @booking.window="eventID = $event.detail.eventID; instanceID = $event.detail.instanceID; event = $event.detail.event; certificate = $event.detail.certificate"
    @keyup.escape.window="closeBooking" x-data="{
        iFrameLoading: true,
        displayAvailabilityBadge: {{ nova_get_setting('display_availability_badge', false) }},
        eventID: null,
        event: null,
        certificate: null,
        instanceID: null,
    
        instances: null,
    
        closeBooking() {
            this.eventID = null;
            this.instanceID = null;
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
        class="bg-black backdrop-blur-lg bg-opacity-60 duration-150 fixed inset-0 z-30"
        x-transition:enter-start="opacity-0" x-transition:leave-end="opacity-0">
    </div>

    <div x-transition:enter-start="translate-y-full lg:translate-y-0 lg:translate-x-full"
        x-transition:leave="translate-y-full lg:translate-y-0 lg:translate-x-full" x-show="eventID"
        class="bg-sand flex flex-col h-screen transition fixed z-50 top-0 bottom-0 right-0 w-full lg:w-[90vw] xl:w-[75vw]">
        <button x-on:click="closeBooking" aria-label="Close booking options"
            class="z-30 top-5 lg:top-[2.5rem] absolute lg:mr-10 right-4 lg:right-full">@svg('plus', 'h-6 w-6 text-black lg:text-white rotate-45 transform origin-center')</button>
        <h2 x-on:click="instanceID = null"
            class="type-regular lg:type-medium lg:justify-between gap-4 flex items-center flex-row cursor-pointer z-10 lg:absolute lg:w-[100vh] lg:right-full lg:text-right py-3 px-4 lg:px-6 lg:p-10 lg:origin-top-right lg:-rotate-90 transform whitespace-nowrap"
            :class="instanceID ? 'bg-yellow-dark cursor-pointer' : 'cursor-default bg-sand-dark lg:bg-sand'">
            <span>Showtimes</span> <span
                class="type-regular lg:type-medium lg:order-last lg:rotate-90 order-first lg:ml-4 inline-block w-12 h-12 py-3.5 lg:w-16 lg:h-16 lg:py-5 !leading-none rounded-full bg-yellow align-middle text-center">1</span>
        </h2>
        <div class="container flex-grow overflow-y-auto flex flex-col relative pt-4 lg:pt-12 lg:pl-48" x-show="eventID">

            <div class="type-medium !font-normal">Select a showtime</div>

            <div x-show="instances === null" x-transition class="absolute inset-0 bg-sand py-16 pl-32">
                @svg('loading', 'w-32 ml-36 block pt-24 text-sand-dark')
            </div>

            <div x-show="instances && !instances.length" x-transition
                class="rounded max-w-md bg-sand-light mt-4 px-6 py-2 font-semibold">

                {!! $settings['no_scheduled_screenings'] ?? 'No scheduled screenings' !!}
            </div>

            <template x-if="instances && instances.length">
                <div class="gap-8 lg:flex-1 flex flex-col lg:flex-row lg:gap-12">
                    <div class="max-w-xl w-full flex flex-col lg:h-full">
                        <div class="mt-1 mb-8"><span class="font-bold" x-html="event"></span> <span
                                class="type-xs-mono bg-gray-dark inline-block min-w-[2em] text-center rounded-full align-middle px-1 text-white"
                                x-html="certificate"></span></div>

                        <div class="pb-4 lg:pr-12 flex-1">
                            <template x-for="(instance, key) in instances">
                                <div>
                                    <h3 x-show="key == 0 ||
                            instances[key - 1].start_date !== instance.start_date"
                                        class="type-small mt-12 mb-3" x-text="instance.start_date"></h3>
                                    <button aria-label="Buy tickets for this screening"
                                        x-on:click="instance.external_ticket_link ? (window.location.href = instance.external_ticket_link) : instanceID = instance.short_id"
                                        :class="instances[key + 1]?.start_date !== instance.start_date ? 'border-b' : ''"
                                        class="group border-t transition w-full flex flex-row items-center gap-2 lg:gap-4 border-gray-light py-2">
                                        <div class="type-xs-mono !text-base rounded bg-black py-1.5 px-4 text-white"
                                            x-text="instance.start_time">
                                        </div>

                                        <div class="flex sm:items-center flex-col sm:flex-row gap-x-2 gap-y-0.5">
                                            <x-strand.booking-path />
                                            <span
                                                x-show="instance.strand && instance.strand.show_in_booking_path && (instance.captioned || instance.event.audio_description || instance.signed_bsl || instance.toddler_friendly) "
                                                class="hidden sm:inline-block text-2xl">&middot;</span>
                                            <x-accessibilities.booking-path />

                                        </div>

                                        <div class="ml-auto flex flex-row items-center gap-3">

                                            <x-availability-badge x-show="displayAvailabilityBadge" />

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
                    <div x-show="instances && instances.length && instances.some((instance) => instance.event.audio_description || instance.captioned || instance.autism_friendly)"
                        class="pb-8 lg:text-center max-w-lg lg:max-w-xs lg:w-1/3 lg:pt-[6.9rem]">
                        <h3 class="type-small mb-3">{{ $settings['access_key'] ?? 'Key' }}</h3>

                        <div x-show="instances.some((instance) => instance.event.audio_description)"
                            class="border-t last:border-b border-gray-light py-4">
                            <span
                                class="type-xs-mono inline-block bg-gray-dark rounded-full text-white no-underline px-2 text-center cursor-default z-[2]">AD</span>
                            <p class="type-small mt-2 !font-normal">Audio Description available via headsets. These can
                                be
                                reserved in next booking stage.</p>

                        </div>
                        <div x-show="instances.some((instance) => instance.captioned)"
                            class="border-t last:border-b border-gray-light py-4">
                            <span
                                class="type-xs-mono inline-block bg-gray-dark rounded-full text-white no-underline px-2 text-center cursor-default z-[2]">Captioned</span>
                            <p class="type-small mt-2 !font-normal">Descriptive subtitles for the benefit of audiences
                                who
                                are Deaf or Hard of Hearing.</p>

                        </div>

                        <div x-show="instances.some((instance) => instance.autism_friendly)"
                            class="border-t last:border-b border-gray-light py-4">
                            <span
                                class="type-xs-mono inline-block bg-gray-dark rounded-full text-white no-underline px-2 text-center cursor-default z-[2]">Autism-friendly</span>
                            <p class="type-small mt-2 !font-normal">Designed for neurodiverse audiences, these
                                screenings feature prompt start times, raised lighting and reduced volume. Capacity is
                                reduced and audiences can make noise and move around.</p>
                        </div>

                        <div x-show="instances.some((instance) => instance.toddler_friendly)"
                            class="border-t last:border-b border-gray-light py-4">
                            <span
                                class="type-xs-mono inline-block bg-gray-dark rounded-full text-white no-underline px-2 text-center cursor-default z-[2]">Toddler-friendly</span>
                            <p class="type-small mt-2 !font-normal">Designed for younger audiences, in particular those who are too old for our Bring Your Own Baby screenings but too young to stay seated! These
                                screenings feature shorter run times and audiences can make noise and move around.</p>
                        </div>

                        <p class="underline mt-6"><a href="/access#accessible-screenings">Learn
                                about
                                accessible screenings</a></p>

                    </div>
                </div>
            </template>
        </div>
    </div>
    <div x-transition:enter-start="translate-y-full lg:translate-y-0 lg:translate-x-full"
        x-transition:leave="translate-y-full lg:translate-y-0 lg:translate-x-full"
        class="w-full flex flex-col lg:w-[calc(90vw-9rem)] xl:w-[calc(75vw-9rem)] z-[60] bg-sand lg:min-h-screen transition fixed top-[4.5rem] lg:top-0 bottom-0 right-0"
        x-show="instanceID && eventID">
        <h2
            class="type-regular lg:type-medium bg-sand-dark lg:bg-transparent lg:justify-between gap-4 flex items-center flex-row z-10 lg:absolute lg:w-[100vh] lg:right-full lg:text-right py-3 px-4 lg:px-6 lg:p-10 lg:origin-top-right lg:-rotate-90 transform whitespace-nowrap">
            <span>Tickets &amp; extras</span> <span
                class="type-regular lg:type-medium lg:order-last lg:rotate-90 order-first lg:ml-4 inline-block w-12 h-12 py-3.5 lg:w-16 lg:h-16 lg:py-5 !leading-none rounded-full bg-yellow align-middle text-center">2</span>
        </h2>
        <div class="flex-grow container overflow-y-auto relative pt-4 lg:pt-12 lg:pl-40" x-show="instanceID">

            <template x-if="instanceID">
                <div class="gap-8 flex-1 flex flex-col lg:flex-row lg:gap-12">

                    <div class="w-full max-w-xl">
                        <div x-show="iFrameLoading" x-transition class="absolute inset-0 bg-sand py-12 lg:pl-32">
                            @svg('loading', 'w-32 mx-auto lg:ml-36 block pt-24 text-sand-dark')

                        </div>
                        <iframe x-on:load="iFrameLoading = false" class="w-full transition-all" id="SpektrixIFrame"
                            style="height: 90vh;" name="SpektrixIFrame"
                            :src="`https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/ChooseSeats.aspx?EventInstanceId=${ instanceID }&resize=true&stylesheet=hpph-spektrix-2.css`"></iframe>

                    </div>

                    <div class="-mt-8 lg:mt-0 pb-8 max-w-lg lg:max-w-xs lg:w-1/3 lg:pt-[8.9rem] lg:mr-4">

                        <div class="mb-8">
                            <h3 class="type-small mb-3">Seating plan key</h3>
                            <div class="border-t border-b border-gray-light py-4">
                                <p class="type-xs"><span
                                        class="inline-block mr-1 translate-y-1/4 w-4 h-4 rounded-full bg-black"></span>
                                    Seat
                                    available
                                </p>
                                <p class="type-xs"><span
                                        class="inline-block mr-1 translate-y-1/4 w-4 h-4 rounded-full bg-[#b9b6b2]"></span>
                                    Seat
                                    unavailable
                                </p>
                                <p class="type-xs mt-0.5 flex items-center gap-1">
                                    <svg class="mr-0.5 w-4 h-auto" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1"
                                        width="483.2226563" height="551.4306641"
                                        viewBox="0 0 483.2226563 551.4306641" overflow="visible"
                                        enable-background="new 0 0 483.2226563 551.4306641" xml:space="preserve">
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
                        <div class="type-xs prose border-t last:border-b border-gray-light py-4">
                            {!! $settings['members_basket_text'] ??
                                'Please select a full-price ticket, any discounts will be applied at checkout after you have signed into your account' !!}
                        </div>
                    </div>
                </div>
            </template>
        </div>

    </div>

</div>
