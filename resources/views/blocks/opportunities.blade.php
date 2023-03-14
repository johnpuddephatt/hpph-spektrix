@if ($layout->opportunities->count())
    <div class="bg-yellow pt-16">
        <div class="">
            <h3 class="type-xs-mono container mb-4">Current opportunities</h3>
            @foreach ($layout->opportunities as $opportunity)
                <a href="{{ route('opportunity.show', ['opportunity' => $opportunity->slug]) }}"
                    class="{{ $loop->odd ? 'bg-white bg-opacity-20' : '' }} group flex container flex-row flex-wrap lg:flex-nowrap items-center border-b border-gray-light py-4">
                    <div class="flex-shrink-0 lg:w-1/2">
                        <span
                            class="type-xs-mono inline-block bg-black w-10 h-10 rounded-full text-yellow text-center py-3">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </span>

                    </div>
                    <div class="flex-grow order-first lg:order-none lg:container">
                        <h3 class="type-regular mb-1">{{ $opportunity->title }}</h3>
                        <div class="type-xs-mono">{{ $opportunity->type }} • Apply by
                            {{ $opportunity->application_deadline }}
                        </div>
                    </div>
                    <div
                        class="type-regular mt-6 w-full group-hover:bg-black-light items-center py-2 text-yellow bg-black ml-auto justify-between lg:w-64 flex rounded-full px-4">
                        Info
                        @svg('arrow-right', 'h-4 w-4 ml-4 text-yellow inline-block')
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
