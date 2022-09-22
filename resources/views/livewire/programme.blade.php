<div class="pb-32">
    <div class="flex flex-row justify-between border-t border-gray-light py-8">
        <div class="flex flex-row items-center gap-2">
            <div class="type-label">View by:</div>
            <x-programme-button :selected="$type" type="latest">Latest</x-programme-button>
            <x-programme-button :selected="$type" type="alphabetical">A&ndash;Z</x-programme-button>
            <x-programme-button :selected="$type" type="schedule">Schedule</x-programme-button>
        </div>
        <div class="flex flex-row items-center gap-2">
            <div class="type-label">Filter by:</div>
            <button wire:click="$set('strand', 'foo')" class="rounded-full border border-gray-light py-1.5 px-4">Strand
                &amp; seasons
                @svg('down-chevron', 'inline-block w-4 h-4')</button>

            <button class="rounded-full border border-gray-light py-1.5 px-4">Accessibility
                @svg('down-chevron', 'inline-block w-4 h-4')</button>
            <button class="rounded-full border border-gray-light py-1.5 px-4">Event
                @svg('down-chevron', 'inline-block w-4 h-4')</button>
            <button class="rounded-full border border-gray-light py-1.5 px-4">Date
                @svg('down-chevron', 'inline-block w-4 h-4')</button>

        </div>
    </div>

    @if ($type == 'latest')
        <livewire:programme.latest />
    @endif

    @if ($type == 'alphabetical')
        <livewire:programme.alphabetical />
    @endif

    @if ($type == 'schedule')
        <livewire:programme.instances :show_header="false" :show_load_more="true" :options="[(array) ['label' => 'Today', 'limit' => 10]]" />
    @endif

</div>
