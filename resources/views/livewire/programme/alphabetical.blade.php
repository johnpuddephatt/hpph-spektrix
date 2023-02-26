<div class="md:container divide-y divide-gray-light pt-3 pb-8">
    <div class="overflow-hidden">
        @php $events = $events->concat($events)->concat($events) @endphp
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 -mx-2 -mb-px">
            @foreach ($events as $event)
                <x-event-card :event="$event" />
            @endforeach
        </div>
    </div>
</div>
