<div x-init="$dispatch('eventcount', { number: null })" class="divide-y divide-gray-light pb-8 pt-3 md:container">
    <div class="overflow-hidden">
        @if (count($events))
            <div class="-mx-2 -mb-px grid bg-sand-light md:grid-cols-2 md:bg-transparent lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($events as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
        @else
            <div class="type-regular py-24 text-center">No events found.</div>

        @endif
        {{ $events->links() }}

    </div>
</div>
