@props(['dark' => false, 'instance'])

<div {{ $attributes->class(['cursor-default container transition duration-500']) }}>
    <div class="border-b-[0.5px] border-gray-light py-4 relative flex flex-col gap-3 lg:flex-row items-start lg:gap-6">

        @if ($instance->event->featuredImage)
            <div class="w-2/12">
                <x-image :width="'20rem'" :src="$instance->event->featuredImage->getUrl('wide')" :srcset="$instance->event->featuredImage->getSrcset('wide')" class="w-full overflow-hidden rounded" />
            </div>
        @endif

        <div class="flex w-10/12 flex-col self-stretch items-start lg:w-4/12">
            <h4 class="type-regular overflow-hidden text-ellipsis">
                {{ $instance->event->name }}
                <x-certificate class="align-middle" :dark="true" :certificate="$instance->event->certificate_age_guidance" />
            </h4>
            <a class="type-small bg-sand-light inline-block mt-auto mb-2 px-4 rounded-full"
                href="{{ route('event.show', ['event' => $instance->event->slug]) }}">Film info</a>
        </div>

        <div class="border-l border-gray-light pl-4 flex w-10/12 flex-col self-stretch lg:w-4/12">

            <div class="flex flex-row items-center gap-1.5">@svg('clock', ' w-4 h-4')
                <div class="type-regular !leading-none">{{ $instance->start->format('H:i') }}</div>
                <x-accessibilities :dark="true" :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->audio_described" />
            </div>

            <div class="mt-auto mr-auto mb-2 flex flex-row gap-2 items-center">
                <x-strand-badge class="" :strand="$instance->strand" />
                <x-accessibilities :dark="false" :specialevent="$instance->special_event" />
            </div>
        </div>

        <a class="type-regular translate-x-1.5 justify-between pl-4 p-1 w-2/12 bg-yellow rounded-full items-center flex flex-row"
            href="{{ route('event.show', ['event' => $instance->event->slug]) }}">
            Book @svg('arrow-right', 'block text-yellow p-2 ml-2 flex-shrink-0 h-7 w-7 bg-black rounded-full')</a>
    </div>

</div>
