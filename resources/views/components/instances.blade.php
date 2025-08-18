@props(['instances', 'options'])

<div class="pb-16">
    @forelse ($instances as $instance)
        @if ($loop->index == 0 || $instances->get($loop->index - 1)->start_date !== $instance->start_date)
            <div id="{{ Str::slug($instance->start_date) }}" class="absolute left-0 right-0 h-9 bg-sand-light lg:h-0">
            </div>

            <h3
                class="type-xs-mono container sticky top-3 z-10 flex justify-center border-sand first:mt-0 lg:top-[6.95rem] lg:mt-12 lg:block lg:border-b lg:bg-sand-light">
                <a href="#{{ Str::slug($instance->start_date) }}"
                    class="block rounded-full bg-sand-light px-6 py-2.5 lg:px-0 lg:py-3.5">

                    {{ $instance->start_date }}
                </a>
            </h3>
        @endif

        <x-instance-row :instance="$instance" :dark="false" />

    @empty
        <div class="type-regular py-24 text-center">No screenings found.</div>
    @endforelse
</div>
