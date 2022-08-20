@props(['dark' => false, 'instances', 'options', 'selected_option'])

<div x-data="{ open: null }" class="mb-16">
    @forelse ($instances as $instance)
        @if ($options[$selected_option]['duration'] > 1 &&
            ($loop->index == 0 ||
                $instances->get($loop->index - 1)->start->format('l d F, Y') !== $instance->start->format('l d F, Y')))
            <h3 class="border-t border-gray-light py-6 font-bold">{{ $instance->start->format('l d F, Y') }}</h3>
        @endif
        <div x-on:click="open = (open == {{ $loop->index }}) ? null : {{ $loop->index }}"
            {{ $attributes->class(['cursor-default border-t-[0.5px] border-gray-medium py-4 transition duration-500', 'hover:bg-gray-dark' => $dark, 'hover:bg-gray' => !$dark]) }}
            x-bind:class="open == {{ $loop->index }} ? 'hover:bg-opacity-50' : 'hover:bg-opacity-50'">
            <div class="relative flex flex-col gap-3 lg:flex-row lg:items-center lg:gap-6">
                <div class="flex w-10/12 max-w-sm flex-col lg:w-1/4">
                    <div class="flex flex-row gap-2">
                        <span class="type-label">{{ $instance->start->format('H:i') }}</span>

                        <x-location color="text-gray-medium" :location="$instance->venue" />
                    </div>
                </div>

                <div class="flex w-10/12 max-w-md flex-col lg:w-1/3">
                    <h4 class="type-subtitle overflow-hidden text-ellipsis !leading-none">
                        {{ $instance->event->name }}
                    </h4>
                </div>

                <div class="flex flex-row items-center gap-2">
                    <x-certificate :dark="$dark" :certificate="$instance->event->certificate_age_guidance" />
                    <x-strand :strand="$instance->strand" />
                    <x-accessibilities :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->audio_described" />
                </div>

                <a @click.stop href="{{ route('event.show', ['event' => $instance->event->slug]) }}"
                    {{ $attributes->class(['absolute lg:static bottom-0 right-0 type-subtitle  ml-auto mb-auto rounded lg:px-6 lg:py-1 ', '-mt-1.5 border-2 border-yellow text-yellow hover:bg-yellow hover:text-black' => $dark, 'bg-gray hover:bg-yellow' => !$dark]) }}>
                    @svg('right-chevron', 'h-10 w-10 lg:hidden')<span class="hidden lg:inline">Info &amp; Tickets</span></a>
                <button aria-label="Toggle details"
                    class="absolute top-0 right-0 -mt-1.5 h-9 w-9 rounded-lg text-6xl leading-none lg:static">
                    @svg('plus', 'h-6 w-6')
                </button>
            </div>

            <div class="flex flex-col gap-6 lg:flex-row" x-cloak class="mt-auto overflow-hidden pt-4"
                x-show="open == {{ $loop->index }}" x-transition:enter="transition-all ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-2">
                <div class="flex w-10/12 flex-col pt-6 lg:w-1/4">
                    @if ($instance->event->featuredImage)
                        <x-image :src="$instance->event->featuredImage->getUrl('wide')" :srcset="$instance->event->featuredImage->getSrcset('wide')" class="w-48 overflow-hidden rounded-lg" />
                    @endif
                </div>
                <div class="flex w-10/12 flex-col lg:w-1/3">
                    <div class="type-label mt-4 mb-0.5">{{ $instance->event->year_of_production }} <span
                            x-show="{{ ($instance->event->year_of_production && $instance->event->duration) == 1 ? 'true' : 'false' }}">|</span>
                        {{ $instance->event->duration }}</div>

                    <x-genres-vibes-badge :values="$instance->event->genres_and_vibes" />

                    <p class="mt-auto overflow-hidden pt-4">
                        {{ Illuminate\Support\Str::limit($instance->event->description, 120) }}</p>
                </div>

            </div>
        </div>
    @empty
        <div class="type-subtitle py-24">No screenings found.</div>
    @endforelse
</div>
