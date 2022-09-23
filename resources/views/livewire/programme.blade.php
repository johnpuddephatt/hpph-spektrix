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

            @if ($strand)
                <button
                    class="relative z-10 rounded-full border border-gray-light py-1.5 px-4 group-hover:border-yellow group-hover:bg-yellow"
                    wire:click="$emit('updateStrand', null)">
                    {{ $strands_with_showings[$strand] }}
                    @svg('plus', 'rotate-45 inline-block ml-1 w-4 h-4')</button>
            @elseif ($season)
                <button
                    class="relative z-10 rounded-full border border-gray-light py-1.5 px-4 group-hover:border-yellow group-hover:bg-yellow"
                    wire:click="$emit('updateSeason', null)">
                    {{ $seasons_with_showings[$season] }}
                    @svg('plus', 'rotate-45 inline-block ml-1 w-4 h-4')</button>
            @else
                @if (count($seasons_with_showings) || count($strands_with_showings))
                    <div class="group relative hover:z-20">
                        <div
                            class="relative z-10 rounded-full border border-gray-light py-1.5 px-4 group-hover:border-yellow group-hover:bg-yellow">
                            Strands
                            &amp; seasons
                            @svg('down-chevron', 'group-hover:rotate-180 transform transition inline-block ml-1 w-4 h-4')</div>
                        <div
                            class="absolute top-0 left-0 hidden min-w-full rounded-tl-3xl bg-yellow pt-12 pb-4 hover:block group-hover:block">
                            @foreach ($strands_with_showings as $slug => $strand_label)
                                <button wire:click="$emit('updateStrand', '{{ $slug }}' )"
                                    class="px-4 py-1 before:mr-1 before:mb-0.5 before:inline-block before:h-2 before:w-2 before:rounded-full before:border before:border-black hover:before:bg-black">{{ $strand_label }}</button>
                            @endforeach
                            @foreach ($seasons_with_showings as $slug => $season_label)
                                <button wire:click="$emit('updateSeason', '{{ $slug }}' )"
                                    class="px-4 py-1 before:mr-1 before:mb-0.5 before:inline-block before:h-2 before:w-2 before:rounded-full before:border before:border-black hover:before:bg-black">{{ $season_label }}</button>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (count($accessibilities_with_showings))
                    <div class="group relative hover:z-20">
                        <div
                            class="relative z-10 rounded-full border border-gray-light py-1.5 px-4 group-hover:border-yellow group-hover:bg-yellow">
                            Accessibility
                            @svg('down-chevron', 'group-hover:rotate-180 transform transition inline-block ml-1 w-4 h-4')</div>
                        <div
                            class="absolute top-0 left-0 hidden min-w-full rounded-tl-3xl bg-yellow pt-12 pb-4 hover:block group-hover:block">
                            @foreach ($accessibilities_with_showings as $slug => $accessibility_label)
                                <button wire:click="$emit('updateAccessibility', '{{ $slug }}' )"
                                    class="whitespace-nowrap px-4 py-1 before:mr-1 before:mb-0.5 before:inline-block before:h-2 before:w-2 before:rounded-full before:border before:border-black hover:before:bg-black">{{ $accessibility_label }}</button>
                            @endforeach

                        </div>
                    </div>

                @endif
            @endif

            @if ($date)
                <button
                    class="relative z-10 rounded-full border border-gray-light py-1.5 px-4 group-hover:border-yellow group-hover:bg-yellow"
                    wire:click="$emit('updateDate', null)">

                    {{ date('d M', strtotime($date)) }}

                    @svg('plus', 'rotate-45 inline-block ml-1 w-4 h-4')</button>
            @endif
            <div class="group {{ $date ? 'hidden' : '' }} relative hover:z-20">
                <div
                    class="relative z-10 rounded-full border border-gray-light py-1.5 px-4 group-hover:border-yellow group-hover:bg-yellow">
                    Date
                    @svg('down-chevron', 'group-hover:rotate-180 transform transition inline-block ml-1 w-4 h-4')</div>
                <div
                    class="absolute top-0 right-0 hidden min-w-full rounded-tr-3xl bg-yellow pt-12 hover:block group-hover:block">
                    <x-datepicker />

                </div>
            </div>

        </div>
    </div>

    @if ($type == 'latest')
        <livewire:programme.latest />
    @endif

    @if ($type == 'alphabetical')
        <livewire:programme.alphabetical />
    @endif

    @if ($type == 'schedule')
        <livewire:programme.instances :show_header="false" :show_load_more="true" :options="[(array) ['limit' => 10]]" />

        <!-- x  x:strand="$strand" :season="$season" :date="$date" :accessibility="$accessibility" -->
    @endif

</div>
