<div x-init="$dispatch('eventcount', { number: null })" class="md:container divide-y divide-gray-light pt-3 pb-8">
    <div class="overflow-hidden">
        @if (count($events))
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 -mx-2 -mb-px">
                @foreach ($events as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
        @else
            <div class="type-regular text-center py-24">No events found.</div>

        @endif
        {{ $events->links() }}

    </div>
</div>
