<div x-data="{ open: null }" class="mb-16">
    @forelse ($instances as $instance)
        @if ($options[$selected_option]['duration'] > 1 && ($loop->index == 0 || $instances->get($loop->index - 1)->start->format('l d F, Y') !== $instance->start->format('l d F, Y')))
            <h3 class="border-t border-gray-light py-6 font-bold">{{ $instance->start->format('l d F, Y') }}</h3>
        @endif
        <div x-on:click="open = (open == {{ $loop->index }}) ? null : {{ $loop->index }}"
            class="cursor-default border-t-[0.5px] border-gray-medium py-4 transition duration-500"
            x-bind:class="open == {{ $loop->index }} ? '' : 'hover:bg-gray-dark hover:bg-opacity-50'">
            <div class="flex flex-row items-center gap-6">
                <div class="flex w-1/4 flex-col">
                    <div class="flex flex-row gap-2">
                        <span class="type-label">{{ $instance->start->format('H:i') }}</span>

                        <x-location color="text-gray-medium" :location="$instance->event->venue" />
                    </div>
                </div>

                <div class="flex w-1/3 flex-col">
                    <h4 class="type-subtitle overflow-hidden text-ellipsis !leading-none">
                        {{ $instance->event->name }}
                    </h4>
                </div>

                <div class="flex flex-row items-center gap-2">
                    <x-certificate :certificate="$instance->event->certificate_age_guidance" />
                    <x-strand :strand="$instance->strand" />

                    @if ($instance->event->certificate_age_guidance && ($instance->captioned || $instance->signed_bsl || $instance->audio_described))
                        <span class="mx-1 inline-block h-1 w-1 rounded-full bg-white"></span>
                    @endif

                    <x-accessibilities :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->audio_described" />
                </div>

                <a @click.stop href="{{ route('event.show', ['event' => $instance->event->slug]) }}"
                    class="type-subtitle -mt-1.5 ml-auto mb-auto rounded border-2 border-yellow px-6 py-1 text-yellow hover:bg-yellow hover:text-black">
                    Info &amp; Tickets</a>

                <button class="-mt-1.5 h-9 w-9 rounded-lg bg-gray text-6xl leading-none"></button>
            </div>

            <div class="flex flex-row gap-6" x-cloak class="mt-auto overflow-hidden pt-4"
                x-show="open == {{ $loop->index }}" x-transition:enter="transition-all ease-out duration-500"
                x-transition:enter-start="opacity-0 -translate-y-2">
                <div class="flex w-1/4 flex-col pt-6">
                    @if ($instance->event->featuredImage)
                        <x-image :src="$instance->event->featuredImage->getUrl('wide')" :srcset="$instance->event->featuredImage->getSrcset('wide')" class="w-48 overflow-hidden rounded-lg" />
                    @endif
                </div>
                <div class="flex w-1/3 flex-col">
                    <div class="type-label mt-4 mb-0.5">{{ $instance->event->year_of_production }} <span
                            x-show="{{ ($instance->event->year_of_production && $instance->event->duration) == 1 ? 'true' : 'false' }}">|</span>
                        {{ $instance->event->duration }}</div>

                    <x-genres-vibes :values="$instance->event->genres_and_vibes" />

                    <p class="mt-auto overflow-hidden pt-4">
                        {{ Illuminate\Support\Str::limit($instance->event->description, 120) }}</p>
                </div>

            </div>
        </div>
    @empty
        <div class="type-subtitle py-24">No screenings found.</div>
    @endforelse
</div>
