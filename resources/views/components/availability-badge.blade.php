<div x-show="!instance.availability.seats"
    class="type-xs-mono type-xs-mono ml-auto flex items-center rounded flex-row bg-gray border border-sand-dark px-2"
    :title="instance.availability.seats ?
        `There are ${instance.availability.seats} regular seats and ${instance.availability.accessible_seats} wheelchair seats available for this screening.` :
        `Regular seating for this screening has sold out. There are ${instance.availability.accessible_seats} wheelchair seats available.`"
    :aria-label="instance.availability.seats ?
        `There are ${instance.availability.seats} regular seats and ${instance.availability.accessible_seats} wheelchair seats available for this screening.` :
        `Regular seating for this screening has sold out. There are ${instance.availability.accessible_seats} wheelchair seats available.`">

    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block opacity-50 w-4 mr-0.5 h-auto" data-name="Layer 1"
        viewBox="0 0 24 24">
        <path fill="currentColor"
            d="M20 11h-1V5a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v6H4a2 2 0 0 0-2 2v8a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1h10v1a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-8a2 2 0 0 0-2-2ZM7 16a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v2H7ZM7 5a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8.18a3 3 0 0 0-1-.18H8a3 3 0 0 0-1 .18V5Zm-3 8h1v7H4Zm16 7h-1v-7h1Z" />
    </svg>
    <span x-text="instance.availability.seats > 0  ? '×' + instance.availability.seats : 'Sold out'"></span>

    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
        width="483.223" height="551.431" class="w-6 border-l opacity-50 border-sand-dark py-1 ml-2 pl-2 h-auto"
        overflow="visible" viewBox="0 0 483.223 551.431">
        <path fill-rule="evenodd" fill="currentColor"
            d="M161.988 98.124c24.963-2.305 44.358-23.811 44.358-48.966C206.346 22.083 184.263 0 157.187 0S108.03 22.083 108.03 49.158c0 8.257 2.304 16.706 6.145 23.81l17.515 246.468 180.397.048 73.991 173.366 97.145-38.098-15.043-35.82-54.367 19.625-71.59-165.28-167.73 1.126-2.303-31.213 121.423.049v-46.183l-126.054-.05-5.57-98.882z"
            clip-rule="evenodd" />
        <path fill-rule="evenodd" fill="currentColor"
            d="M343.42 451.59c-30.447 60.188-94.175 99.84-162.15 99.84C81.43 551.43 0 470.002 0 370.162c0-70.1 42.485-135.244 105.882-164.121l4.102 53.538c-37.497 23.628-60.612 66.262-60.612 110.95 0 72.427 59.071 131.497 131.497 131.497 66.262 0 122.765-50.851 130.47-116.087l32.08 65.653z"
            clip-rule="evenodd" />
    </svg>
    <span x-text="'×' + instance.availability.accessible_seats"></span>

</div>
