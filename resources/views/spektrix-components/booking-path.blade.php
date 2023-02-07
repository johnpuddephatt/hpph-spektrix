<div x-cloak
    @booking.window="eventID = $event.detail.eventID; instanceID = $event.detail.instanceID; venue = $event.detail.venue"
    x-data="{
        iFrameLoading: true,
    
        eventID: null,
        venue: null,
        instanceID: null,
    
    
    
        instances: [],
    
        closeBooking() {
            this.eventID = null;
            this.instanceID = null;
            this.instances = [];
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

    <div x-transition.opacity x-show="eventID" x-on:click="closeBooking" class="bg-black fixed inset-0 z-20"></div>

    <div x-transition:enter-start="translate-x-full" x-transition:leave="translate-x-full" x-show="eventID"
        class="bg-sand lg:min-h-screen transition fixed z-40 top-0 bottom-0 right-0 w-full lg:w-[50vw]">
        <button x-on:click="closeBooking" aria-label="Close booking options"
            class="top-6 absolute mr-6 right-full">@svg('plus', 'h-8 w-8 p-0.5 text-white rotate-45 transform origin-center text-white')</button>
        <h2 x-on:click="instanceID = null"
            class="type-regular cursor-pointer z-10 absolute w-[100vh] right-full text-right p-6 origin-top-right -rotate-90 transform whitespace-nowrap"
            :class="instanceID ? 'bg-yellow-dark' : 'bg-yellow'">
            Available screenings <span
                class="type-medium rotate-90 ml-4 inline-block w-12 h-12 p-3 !leading-none rounded-full bg-black text-yellow align-middle text-center">1</span>
        </h2>
        <div class="container relative py-16 pl-24 lg:pl-32" x-show="eventID">

            <div class="type-medium">Select a showtime</div>

            <div x-show="!instances.length" x-transition class="absolute inset-0 bg-sand py-16 pl-32">
                @svg('loading', 'w-32 ml-36 block pt-24 text-sand-dark')
            </div>
            <div x-show="instances.length">
                <div class="mt-2"><strong>Venue: </strong><span x-text="venue"></span></div>

                <template x-for="(instance, key) in instances">
                    <div>
                        <h3 x-show="key == 0 ||
                            instances[key - 1].start_date !== instance.start_date"
                            class="mt-8 mb-3 font-bold" x-text="instance.start_date"></h3>
                        <div class="flex max-w-xl flex-row items-center gap-2 border-t border-gray-light py-2">
                            <div class="type-xs-mono rounded bg-black py-1.5 px-2.5 text-white"
                                x-text="instance.start_time">
                            </div>
                            {{-- <x-strand :strand="$instance->strand" />
                            <x-accessibilities :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->audio_described"
                                :specialevent="$instance->special_event" /> --}}
                            <button x-on:click="instanceID = instance.id.substr(0,5)"
                                class="ml-auto rounded bg-gray px-16 py-1 font-bold hover:bg-yellow">Tickets</button>
                        </div>
                    </div>
                </template>

                <div x-show="!instances.length" class="mt-12 max-w-md rounded bg-gray py-16 text-center">
                    {!! $settings['no_scheduled_screenings'] ?? 'No scheduled screenings' !!}
                </div>

            </div>
        </div>
    </div>
    <div x-transition:enter-start="translate-x-full" x-transition:leave="translate-x-full"
        class="w-[calc(100vw-5.5rem)] lg:w-[calc(50vw-5.5rem)] z-40 bg-sand lg:min-h-screen transition fixed top-0 bottom-0 right-0"
        x-show="instanceID && eventID">
        <h2
            class="type-regular z-10 absolute w-[100vh] right-full text-right p-6 bg-yellow origin-top-right -rotate-90 transform whitespace-nowrap">
            Tickets and extras <span
                class="type-medium rotate-90 ml-4 inline-block w-12 h-12 p-3 !leading-none rounded-full bg-black text-yellow align-middle text-center">2</span>
        </h2>
        <div class="container relative py-16 pl-32" x-show="instanceID">

            <template x-if="instanceID">
                <div class="max-w-xl">
                    <div x-show="iFrameLoading" x-transition class="absolute inset-0 bg-sand py-16 pl-32">
                        @svg('loading', 'w-32 ml-36 block pt-24 text-sand-dark')

                    </div>
                    <iframe x-on:load="iFrameLoading = false" class="h-96 w-full transition-all" id="SpektrixIFrame"
                        name="SpektrixIFrame"
                        :src="`https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/ChooseSeats.aspx?EventInstanceId=${ instanceID }&resize=true`"></iframe>
                </div>
            </template>
        </div>

        {{-- @if ($event->instances->count())
            <div class="container bg-yellow py-6 pl-32">
                <h2 class="type-medium max-w-[8em]">Want to see this film for free?</h2>
            </div>

            <div class="container relative py-8 pl-32">
                <div class="type-xs-mono absolute right-full origin-right translate-x-8 -rotate-90 transform">
                    Memberships</div>
                <div class="max-w-xs">Become a HPPH member and receive free tickets plus loads of exclusive
                    benefits.
                </div>

                @include('spektrix-components.memberships')
            </div>
            @endif --}}
    </div>

</div>
