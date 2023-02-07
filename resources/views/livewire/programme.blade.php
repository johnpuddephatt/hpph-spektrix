<div class="bg-sand px-4 2xl:px-6 pt-24 pb-8 flex flex-row items-end justify-between">
    @if (isset($count))
        <h1 class="type-medium lg:type-large">Results <span class="font-normal">[{{ $count }}]</span></h1>
    @else
        <h1 class="type-medium lg:type-large">What’s on</h1>
    @endif
</div>

<div class="flex flex-col-reverse lg:block">
    <div
        class="bg-sand-light z-10 sticky bottom-0 lg:static lg:bottom-auto lg:container lg:flex flex-row justify-between border-b border-sand lg:py-2">
        <div class="grid grid-cols-2 lg:flex flex-row items-center lg:gap-2">
            <div class="type-xs-mono hidden lg:block">View:</div>
            <x-programme-button :selected="$type" type="schedule">Schedule</x-programme-button>

            <x-programme-button :selected="$type" type="alphabetical">A&ndash;Z</x-programme-button>
        </div>
        <div class="grid grid-cols-3 px-4 py-3 lg:flex flex-row items-center gap-4 lg:gap-2">
            <div class="type-xs-mono hidden lg:block">Filter:</div>
            @if ($strand)
                <button
                    class="type-xs-mono cursor-default rounded bg-yellow hover:bg-yellow-dark relative z-10 pt-2 py-1.5 px-3"
                    wire:click="$emit('updateStrand', null)">
                    {{ $strands_with_showings[$strand] }}
                    @svg('plus', 'rotate-45 align-top inline-block ml-1 w-3 h-3')</button>
                @svg('plus', 'rotate-45 align-top inline-block ml-1 w-3 h-3')</button>
            @else
                @if (count($strands_with_showings))

                    <button x-on:click="$refs.stranddialog.showModal()"
                        class="type-xs-mono cursor-default rounded bg-sand hover:bg-sand-dark relative z-10 pt-2 py-1.5 px-3">
                        Strands
                        @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                    <dialog x-ref="stranddialog"
                        class="opacity-0 open:opacity-100 transition max-w-md rounded fixed top-1/2 m-0 w-full left-1/2 bg-sand p-12 z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
                        <form method="dialog">
                            @foreach ($strands_with_showings as $slug => $strand_label)
                                <button wire:click="$emit('updateStrand', '{{ $slug }}' )"
                                    class="px-4 py-1 before:mr-1 before:mb-0.5 before:inline-block before:h-2 before:w-2 before:rounded-full before:border before:border-black hover:before:bg-black">{{ $strand_label }}</button>
                            @endforeach
                            <button value="cancel">Cancel</button>
                        </form>
                    </dialog>

                @endif
            @endif

            @if (count($accessibilities_with_showings))

                @if ($accessibility)
                    <button
                        class="type-xs-mono cursor-default rounded bg-yellow hover:bg-yellow-dark relative z-10 pt-2 py-1.5 px-3"
                        wire:click="$emit('updateAccessibility', null)">
                        {{ $accessibilities_with_showings[$accessibility] }}
                        @svg('plus', 'rotate-45 align-top inline-block ml-1 w-3 h-3')</button>
                @else
                    <button x-on:click="$refs.accessdialog.showModal()"
                        class="type-xs-mono cursor-default rounded bg-sand hover:bg-sand-dark relative z-10 pt-2 py-1.5 px-3">
                        Access
                        @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                @endif
                <dialog x-ref="accessdialog"
                    class="max-w-md rounded fixed top-1/2 m-0 w-full left-1/2 bg-sand p-12 z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
                    <form method="dialog">
                        @foreach ($accessibilities_with_showings as $slug => $accessibility_label)
                            <button wire:click="$emit('updateAccessibility', '{{ $slug }}' )"
                                class="whitespace-nowrap px-4 py-1 before:mr-1 before:mb-0.5 before:inline-block before:h-2 before:w-2 before:rounded-full before:border before:border-black hover:before:bg-black">{{ $accessibility_label }}</button>
                        @endforeach
                        <button value="cancel">Cancel</button>
                    </form>
                </dialog>

            @endif

            @if ($date)
                <button
                    class="type-xs-mono cursor-default rounded bg-yellow hover:bg-yellow-dark relative z-10 pt-2 py-1.5 px-3"
                    wire:click="$emit('updateDate', null)">

                    {{ date('d M', strtotime($date)) }}

                    @svg('plus', 'rotate-45 inline-block ml-1 align-top w-3 h-3')</button>
            @else
                <button x-on:click="$refs.datedialog.showModal()"
                    class="type-xs-mono cursor-default rounded bg-sand hover:bg-sand-dark relative z-10 pt-2 py-1.5 px-3">
                    Date
                    @svg('plus', 'inline-block align-top ml-2 w-3 h-3')</button>
                <dialog x-ref="datedialog"
                    class="max-w-md rounded fixed top-1/2 m-0 w-full left-1/2 bg-sand p-12 z-40 backdrop:bg-black backdrop:backdrop-blur-lg backdrop:bg-opacity-60 transform -translate-x-1/2 -translate-y-1/2">
                    <form method="dialog">
                        <x-datepicker />
                        <button value="cancel">Cancel</button>
                    </form>
                </dialog>
            @endif
        </div>
    </div>

    <div class="bg-sand">
        @if ($type == 'alphabetical')
            <livewire:programme.alphabetical />
        @elseif ($type == 'schedule')
            <livewire:programme.instances :show_header="false" :show_load_more="true" :options="[(array) ['limit' => 10]]" />
        @endif
    </div>
</div>
