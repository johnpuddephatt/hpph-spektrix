@props(['why_watch'])

@if ($why_watch && $why_watch->enabled)
    <div class="bg-yellow rounded-r lg:rounded max-w-lg">
        <div class="pl-[20%] lg:pl-[25%] p-4">
            <h3
                class="type-xs-mono absolute right-full origin-right translate-x-8 lg:translate-x-12 -rotate-90 transform whitespace-nowrap">
                Why
                watch?</h3>
            <div class="flex flex-col items-start">
                <div>
                    <blockquote>
                        <p class="type-regular max-w-xs relative mb-12 min-h-[6em]"><span
                                class="absolute right-full pr-0.5">“</span>{{ $why_watch->quote }}<span
                                class="pl-0.5">”</span>
                        </p>
                        <cite class="not-italic leading-none">
                            <p class="font-bold">{{ $why_watch->name }},</p>
                            {{ $why_watch->role }}
                        </cite>
                    </blockquote>

                </div>
            </div>
        </div>
    </div>
@endif
