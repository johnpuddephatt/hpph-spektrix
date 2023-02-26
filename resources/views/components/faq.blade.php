@if ($more_information->enabled ?? false)
    <div class="grid container grid-cols-2 bg-black text-white py-16">

        <h3 class="type-regular py-6" style="color: {{ $strand->color }}">
            {{ $more_information->title }}</h3>

        <div class="divide-y divide-gray-dark">

            @foreach ($more_information->faqs as $faq)
                <details v-for="faq in faqs">
                    <summary style="color: {{ $strand->color }}"
                        class="group lg:type-regular container focus-visible:outline-none focus:outline-none focus:bg-white focus:bg-opacity-10 leading-tight font-bold py-6 flex items-center justify-between gap-2">
                        <div class="group-hover:text-[inherit] text-white">{{ $faq->attributes->question }}</div>
                        @svg('plus', 'text-white w-6 h-6')
                    </summary>
                    @include('components.editorjs', [
                        'content' => json_decode($faq->attributes->answer),
                    ])

                </details>
            @endforeach

        </div>
    </div>
@endif
