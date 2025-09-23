@props(['instance'])

<div {{ $attributes->class('uppercase type-xs font-bold px-2.5 py-0.5 text-black ml-auto flex items-center rounded flex-row bg-sand-light') }}
    x-cloak
    x-show="(instance.availability.seats / instance.availability.capacity) <= {{ nova_get_setting('availability_threshold', 0.15) }}"
    :title="instance.availability.seats ?
        `There are ${instance.availability.seats} regular seats and ${instance.availability.accessible_seats} wheelchair seats available for this screening.` :
        `Regular seating for this screening has sold out. There are ${instance.availability.accessible_seats} wheelchair seats available.`"
    :aria-label="instance.availability.seats ?
        `There are ${instance.availability.seats} regular seats and ${instance.availability.accessible_seats} wheelchair seats available for this screening.` :
        `Regular seating for this screening has sold out. There are ${instance.availability.accessible_seats} wheelchair seats available.`"
    @if ($instance ?? false) x-data='{ instance: { availability: @json($instance->availability) } }' @endif>

    <span class="pt-0.5 leading-none"
        x-html="instance.availability.seats > 0  ? '<span class=\'rounded-full text-center bg-black mr-1 size-3 -mt-0.5 inline-block text-white font-bold\'>!</span>Last few' : 'Sold out'"></span>

    <div class="flex items-center pt-0.5 font-normal leading-none"
        x-show="instance.availability.seats == 0 && instance.availability.accessible_seats > 0">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
            width="483.223" height="551.431" class="-mt-0.5 h-auto w-5 pl-2 text-black" overflow="visible"
            viewBox="0 0 483.223 551.431">
            <path fill-rule="evenodd" fill="currentColor"
                d="M161.988 98.124c24.963-2.305 44.358-23.811 44.358-48.966C206.346 22.083 184.263 0 157.187 0S108.03 22.083 108.03 49.158c0 8.257 2.304 16.706 6.145 23.81l17.515 246.468 180.397.048 73.991 173.366 97.145-38.098-15.043-35.82-54.367 19.625-71.59-165.28-167.73 1.126-2.303-31.213 121.423.049v-46.183l-126.054-.05-5.57-98.882z"
                clip-rule="evenodd" />
            <path fill-rule="evenodd" fill="currentColor"
                d="M343.42 451.59c-30.447 60.188-94.175 99.84-162.15 99.84C81.43 551.43 0 470.002 0 370.162c0-70.1 42.485-135.244 105.882-164.121l4.102 53.538c-37.497 23.628-60.612 66.262-60.612 110.95 0 72.427 59.071 131.497 131.497 131.497 66.262 0 122.765-50.851 130.47-116.087l32.08 65.653z"
                clip-rule="evenodd" />
        </svg>
        ×
        <span class="font-bold leading-none" x-text="instance.availability.accessible_seats"></span>
    </div>

</div>
