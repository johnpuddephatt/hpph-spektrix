<div class="container max-w-6xl">
    <details class="max-w-2xl">
        <summary
            class="type-regular flex list-none flex-row gap-4 border-t border-gray-light py-4 focus-within:outline-none hover:bg-gray">
            {!! $summary !!}
            @svg('plus', 'ml-auto')</summary>
        <div class="border-t border-gray py-6">{!! $details !!}</div>
    </details>
</div>
