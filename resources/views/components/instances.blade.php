@props(['instances', 'options'])

<div class="pb-16">
    @forelse ($instances as $instance)
        @if ($loop->index == 0 || $instances->get($loop->index - 1)->start_date !== $instance->start_date)
            <h3 class="type-xs-mono bg-sand-light container py-3 lg:py-4 mt-12 lg:mt-24 first:mt-0">
                {{ $instance->start_date }}
            </h3>
        @endif

        <x-instance-row :instance="$instance" :dark="false" />

    @empty
        <div class="type-regular text-center py-24">No screenings found.</div>
    @endforelse
</div>
