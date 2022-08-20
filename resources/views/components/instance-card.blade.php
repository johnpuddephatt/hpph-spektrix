<div class="flex w-[30%] flex-none flex-col">

    <div class="mb-4 aspect-video overflow-hidden rounded-lg bg-gray">
        @if ($instance->event->featuredImage)
            <x-image class="block w-full" :src="$instance->event->featuredImage->getUrl('wide')" :srcset="$instance->event->featuredImage->getSrcset('wide')" />
        @endif
    </div>

    <div class="mb-3">{{ $instance->start->format('H:i • j F') }}</div>
    <h2 class="type-h4 mb-3">{{ $instance->event->name }}</h2>

    <div class="space-between flex flex-row items-center gap-4 py-2">

        <div class="flex flex-row items-center gap-2">
            <x-certificate :dark="true" :certificate="$instance->event->certificate_age_guidance" />
            {{-- @foreach ($event->strands as $strand)
                    <x-strand :strand="$strand" />
                @endforeach --}}
            <x-accessibilities :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->audio_described" />
        </div>

        <x-location color="text-gray" :location="$instance->venue" />

    </div>
    <div class="mb-4 flex flex-grow flex-row gap-16">
        <div class="flex flex-col justify-end py-4">

            <div class="type-label mb-1">
                {{ $instance->event->year_of_production }}&thinsp;|&thinsp;{{ $instance->event->duration }}
            </div>
            <x-genres-vibes-badge :values="$instance->event->genres_and_vibes" />
            @if ($instance->event->description)
                <p class="mb-auto overflow-hidden pt-4">
                    {{ Illuminate\Support\Str::limit($instance->event->description, 120) }}</p>
            @endif
        </div>

    </div>
    <a style="border-color: {{ $strand->color }}; color: {{ $strand->color }}"
        class="type-subtitle mr-auto mt-auto rounded border py-3 px-8 text-center"
        href="{{ route('event.show', ['event' => $instance->event->slug]) }}">Info &amp; tickets</a>
</div>
