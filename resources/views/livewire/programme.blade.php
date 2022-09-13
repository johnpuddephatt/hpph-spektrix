<div>
    <div class="flex flex-row items-center gap-2 border-t border-gray-light py-8">
        <div class="type-label">View by:</div>
        <x-programme-button :selected="$type" type="latest">Latest</x-programme-button>
        <x-programme-button :selected="$type" type="alphabetical">A&ndash;Z</x-programme-button>
        <x-programme-button :selected="$type" type="schedule">Schedule</x-programme-button>
    </div>

    @if ($type == 'latest')
        <livewire:programme.latest />
    @endif

    @if ($type == 'alphabetical')
        <livewire:programme.alphabetical />
    @endif

    @if ($type == 'schedule')
        <livewire:programme.instances :show_header="false" :show_load_more="true" :options="[(object) ['label' => 'Today', 'offset' => 0, 'duration' => 14]]" />
    @endif

</div>
