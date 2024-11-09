@if ($event)
    <a href="{{ $event->url }}" class="group bg-sand-light rounded-r lg:rounded max-w-lg mt-4">
        <div class="p-4 pl-[20%] lg:pl-[25%]">
            <div
                class="type-xs-mono absolute right-full origin-right translate-x-8 lg:translate-x-12 -rotate-90 transform whitespace-nowrap">
                Related</div>
            <div class="">

                @if ($event->featuredImage)
                    <div class="overflow-hidden w-64 rounded">
                        {!! $event->featuredImage->img('wide')->attributes(['class' => 'group-hover:scale-105 transition duration-500 w-64 ']) !!}
                    </div>
                @else
                    <div class="w-64 aspect-video rounded bg-gray-light"></div>
                @endif
                <x-strand.badge class="max-md:px-4 max-md:text-left max-md:py-2 max-md:rounded-none md:mt-2"
                    :partof="false" :strand="$event->strand" />

                <div class="">
                    <h2 class="type-regular mb-1 mt-3">{{ $event->name }}</h2>
                    <div class="type-xs-mono">
                        {{ $event->date_range }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </a>

@endif
