@if ($members_voices->enabled ?? false)
    <div class="flex flex-col lg:flex-row">
        <div style="background-color: {{ $strand->color ?? 'black' }}"
            class="flex items-center text-center flex-col justify-center lg:w-1/2">

            <h2 class="type-medium max-w-lg mx-auto mb-6 lg:mb-12">“{{ $members_voices->quote }}”</h2>
            <p class="type-xs-mono mx-auto max-w-md">{{ $members_voices->name }}</p>
            <p class="type-xs-mono mx-auto max-w-md">{{ $members_voices->role }}</p>
        </div>
        <div class="w-3/4 lg:w-1/2">
            {!! $strand->getMedia('content->members_voices->image')->first()->img('landscape', ['class' => 'block  rounded'])->toHtml() !!}
        </div>

    </div>
@endif
