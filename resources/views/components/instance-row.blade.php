@props(['dark' => false, 'instance'])

<div
    {{ $attributes->class(['cursor-default container   transition duration-500', 'hover:bg-gray-dark' => $dark, 'hover:bg-gray' => !$dark]) }}>
    <div class="border-b-[0.5px] border-gray-light py-4 relative flex flex-col gap-3 lg:flex-row items-start lg:gap-6">

        @if ($instance->event->featuredImage)
            <x-image :width="'12rem'" :src="$instance->event->featuredImage->getUrl('wide')" :srcset="$instance->event->featuredImage->getSrcset('wide')" class="w-48 overflow-hidden rounded" />
        @endif

        <div class="flex w-10/12 max-w-md flex-col self-stretch items-start lg:w-4/12">
            <h4 class="type-regular overflow-hidden text-ellipsis">
                {{ $instance->event->name }}
                <x-certificate class="align-middle" :dark="true" :certificate="$instance->event->certificate_age_guidance" />
            </h4>
            <a class="type-small bg-sand-light inline-block mt-auto mb-2 px-4 rounded-full"
                href="{{ route('event.show', ['event' => $instance->event->slug]) }}">Film info</a>
        </div>

        <div class="border-l border-gray-light pl-4 flex w-10/12 max-w-sm flex-col self-stretch lg:w-4/12">

            <div class="flex flex-row">
                <div class="type-regular">{{ $instance->start->format('H:i') }}</div>
                <x-accessibilities :dark="$dark" :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->audio_described" />
            </div>
            <x-location color="text-gray-medium" :location="$instance->venue" />
            <x-strand-badge class="mt-auto" :strand="$instance->strand" />

        </div>

        <a class="type-regular justify-between pl-4 p-1.5 w-2/12 bg-yellow rounded-full items-center flex flex-row"
            href="{{ route('event.show', ['event' => $instance->event->slug]) }}">
            Book @svg('arrow-right', 'block text-yellow p-2 ml-2 flex-shrink-0 h-8 w-8 bg-black rounded-full')</a>
    </div>

</div>
