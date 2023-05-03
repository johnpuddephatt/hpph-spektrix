<div x-cloak
    @booking.window="eventID = $event.detail.eventID; instanceID = $event.detail.instanceID; event = $event.detail.event; certificate = $event.detail.certificate"
    @keyup.escape.window="closeBooking" x-data="{
        iFrameLoading: true,
    
        eventID: null,
        event: null,
        certificate: null,
        instanceID: null,
    
        instances: [],
    
        closeBooking() {
            this.eventID = null;
            this.instanceID = null;
            this.instances = [];
            $dispatch('booking', false)
        },
    
        getInstances(eventID) {
            if (!eventID) {
                this.instances = [];
                return false;
            }
            fetch(`/api/event/${ this.eventID }/instances`)
                .then((response) => response.json())
                .then((json) => this.instances = json);
        },
    }" x-effect="getInstances(eventID)">

    <div x-show="eventID" x-on:click="closeBooking"
        class="bg-black backdrop-blur-lg bg-opacity-60 duration-150 fixed inset-0 z-30"
        x-transition:enter-start="opacity-0" x-transition:leave-end="opacity-0">
    </div>

    <div x-transition:enter-start="translate-y-full lg:translate-y-0 lg:translate-x-full"
        x-transition:leave="translate-y-full lg:translate-y-0 lg:translate-x-full" x-show="eventID"
        class="bg-sand flex flex-col h-screen transition fixed z-50 top-0 bottom-0 right-0 w-full lg:w-[75vw]">
        <button x-on:click="closeBooking" aria-label="Close booking options"
            class="z-30 top-5 lg:top-[2.5rem] absolute lg:mr-10 right-4 lg:right-full">@svg('plus', 'h-6 w-6 text-black lg:text-white rotate-45 transform origin-center')</button>
        <h2 x-on:click="instanceID = null"
            class="type-regular lg:type-medium lg:justify-between gap-4 flex items-center flex-row cursor-pointer z-10 lg:absolute lg:w-[100vh] lg:right-full lg:text-right py-3 px-4 lg:px-6 lg:p-10 lg:origin-top-right lg:-rotate-90 transform whitespace-nowrap"
            :class="instanceID ? 'bg-yellow-dark cursor-pointer' : 'cursor-default bg-sand-dark lg:bg-sand'">
            <span>Showtimes</span> <span
                class="type-regular lg:type-medium lg:order-last lg:rotate-90 order-first lg:ml-4 inline-block w-12 h-12 py-3.5 lg:w-16 lg:h-16 lg:py-5 !leading-none rounded-full bg-yellow align-middle text-center">1</span>
        </h2>
        <div class="container flex-grow overflow-y-auto flex flex-col relative pt-12 lg:pl-48" x-show="eventID">

            <div class="type-medium !font-normal">Select a showtime</div>

            <div x-show="!instances.length" x-transition class="absolute inset-0 bg-sand py-16 pl-32">
                @svg('loading', 'w-32 ml-36 block pt-24 text-sand-dark')
            </div>
            <div class="flex-1 flex flex-col lg:flex-row gap-12" x-show="instances.length">
                <div class="max-w-xl w-full flex flex-col h-full">
                    <div class="mt-1 mb-8"><span class="font-bold" x-text="event"></span> <span
                            class="type-xs-mono bg-gray-dark inline-block min-w-[2em] text-center rounded-full align-middle px-1 text-white"
                            x-text="certificate"></span></div>

                    <div class="pb-4 pr-12 flex-1">
                        <template x-for="(instance, key) in instances">
                            <div>
                                <h3 x-show="key == 0 ||
                            instances[key - 1].start_date !== instance.start_date"
                                    class="type-small mt-12 mb-3" x-text="instance.start_date"></h3>
                                <button aria-label="Buy tickets for this screening"
                                    x-on:click="instanceID = instance.short_id"
                                    class="group border-t last:border-b transition w-full flex flex-row items-center gap-4 border-gray-light py-2">
                                    <div class="type-xs-mono !text-base rounded bg-black py-1 px-3 text-white"
                                        x-text="instance.start_time">
                                    </div>

                                    <x-strand.booking-path />
                                    <span
                                        x-show="instance.strand && (instance.captioned || instance.audio_described || instance.signed_bsl || instance.relaxed)"
                                        class="text-2xl">&middot;</span>
                                    <x-accessibilities.booking-path />

                                    @svg('arrow-right', 'bg-sand-light ml-auto group-hover:bg-yellow rounded-full p-3 h-12 w-12')
                                </button>
                            </div>
                        </template>

                        <div x-show="!instances.length" class="mt-12 max-w-md rounded bg-gray py-16 text-center">
                            {!! $settings['no_scheduled_screenings'] ?? 'No scheduled screenings' !!}
                        </div>
                    </div>

                </div>
                <div x-show="instances.some((instance) => instance.relaxed || instance.audio_described || instance.captioned)"
                    class="pb-8 lg:text-center max-w-lg lg:max-w-xs lg:w-1/3 pt-[6.9rem]">
                    <h3 class="type-small mb-3">{{ $settings['access_key'] ?? 'Key' }}</h3>

                    <div x-show="instances.some((instance) => instance.audio_described)"
                        class="border-t last:border-b border-gray-light py-4">
                        <span
                            class="type-xs-mono inline-block bg-gray-dark rounded-full text-white no-underline px-2 text-center cursor-default z-[2]">AD</span>
                        <p class="type-small mt-2 !font-normal">Audio Description available. Headsets
                            can be reserved in advance during the
                            next stage of booking.</p>

                    </div>
                    <div x-show="instances.some((instance) => instance.captioned)"
                        class="border-t last:border-b border-gray-light py-4">
                        <span
                            class="type-xs-mono inline-block bg-gray-dark rounded-full text-white no-underline px-2 text-center cursor-default z-[2]">Captioned</span>
                        <p class="type-small mt-2 !font-normal">Fully subtitled for the benefit of audiences who are
                            Deaf or Hard of Hearing.</p>

                    </div>
                    <div x-show="instances.some((instance) => instance.relaxed)"
                        class="border-t last:border-b border-gray-light py-4">
                        <span
                            class="type-xs-mono inline-block bg-gray-dark rounded-full text-white no-underline px-2 text-center cursor-default z-[2]">Relaxed</span>
                        <p class="type-small mt-2 !font-normal">Relaxed screenings start promptly with no
                            ads/trailers, raised lighting and reduced volume. Audiences can make noise
                            and move around.</p>
                    </div>

                    <p class="type-xs-mono underline mt-6"><a
                            href="https://hpph.letsdance.agency/access#accessible-screenings">More about
                            accessibile screenings</a></p>

                </div>
            </div>
        </div>
    </div>
    <div x-transition:enter-start="translate-y-full lg:translate-y-0 lg:translate-x-full"
        x-transition:leave="translate-y-full lg:translate-y-0 lg:translate-x-full"
        class="w-full flex flex-col lg:w-[calc(75vw-9rem)] z-[60] bg-sand lg:min-h-screen transition fixed top-[4.5rem] lg:top-0 bottom-0 right-0"
        x-show="instanceID && eventID">
        <h2
            class="type-regular lg:type-medium bg-sand-dark lg:bg-transparent lg:justify-between gap-4 flex items-center flex-row z-10 lg:absolute lg:w-[100vh] lg:right-full lg:text-right py-3 px-4 lg:px-6 lg:p-10 lg:origin-top-right lg:-rotate-90 transform whitespace-nowrap">
            <span>Tickets &amp; extras</span> <span
                class="type-regular lg:type-medium lg:order-last lg:rotate-90 order-first lg:ml-4 inline-block w-12 h-12 py-3.5 lg:w-16 lg:h-16 lg:py-5 !leading-none rounded-full bg-yellow align-middle text-center">2</span>
        </h2>
        <div class="flex-grow container overflow-y-auto relative pt-12 lg:pl-48" x-show="instanceID">

            <template x-if="instanceID">
                <div class="flex-1 flex flex-col lg:flex-row gap-12">

                    <div class="w-full max-w-xl">
                        <div x-show="iFrameLoading" x-transition class="absolute inset-0 bg-sand py-12 pl-32">
                            @svg('loading', 'w-32 lg:ml-36 block pt-24 text-sand-dark')

                        </div>
                        <iframe x-on:load="iFrameLoading = false" class="w-full transition-all" id="SpektrixIFrame"
                            style="height: 90vh;" name="SpektrixIFrame"
                            :src="`https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/ChooseSeats.aspx?EventInstanceId=${ instanceID }&resize=true`"></iframe>
                    </div>
                    <div class="max-w-lg lg:max-w-xs lg:w-1/3 pt-[6.9rem]">
                        <h3 class="type-small mb-3">{{ $settings['members_basket_heading'] ?? 'Members' }}</h3>
                        <div class="type-xs border-t last:border-b border-gray-light py-4">
                            {!! $settings['members_basket_text'] ??
                                'Please select a full-price ticket, any discounts will be applied at checkout after you have signed into your account' !!}
                        </div>
                    </div>
                </div>
            </template>
        </div>

    </div>

</div>
