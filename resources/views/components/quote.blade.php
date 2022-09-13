@if ($members_voices->enabled ?? false)
    <div class="border-t-8 bg-sand py-24" style="border-color: {{ $strand->color }}">
        <div class="relative">
            <div class="type-label transform pb-6 text-center lg:absolute lg:top-1/2 lg:-rotate-90 lg:pb-0">Members’
                voices
            </div>

            <div class="container mx-auto max-w-6xl 2xl:max-w-7xl">

                <div class="flex flex-col items-center gap-8 lg:flex-row">
                    <div class="w-3/4 lg:w-1/2">
                        {!! $strand->getMedia('content->members_voices->image')->first()->img('landscape', ['class' => 'block  rounded'])->toHtml() !!}
                    </div>

                    <div class="w-3/4 text-center lg:w-1/2">
                        <div class="type-h2 -mb-4 lg:mb-0" style="color: {{ $strand->color }}">“</div>
                        <h2 class="type-h4 mb-4 lg:mb-8">{{ $members_voices->quote }}</h2>
                        <p class="mx-auto max-w-md font-bold">{{ $members_voices->name }}</p>
                        <p class="mx-auto max-w-md">{{ $members_voices->role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
