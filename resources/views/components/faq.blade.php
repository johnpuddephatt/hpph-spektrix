@if ($more_information->enabled ?? false)
    <div class="flex-row bg-black lg:flex text-white py-16">
        <div class="relative lg:w-1/2">
            <h3 class="type-regular absolute left-4 top-4 lg:left-8 lg:top-8" style="color: {{ $strand->color }}">
                {{ $more_information->title }}</h3>
        </div>
        <div class="lg:container lg:mt-0 lg:w-1/2 lg:py-8 max-w-xl divide-y divide-gray-dark">

            @foreach ($more_information->faqs as $faq)
                <details v-for="faq in faqs">
                    <summary style="color: {{ $strand->color }}"
                        class="group lg:type-subtitle ho container focus-visible:outline-none focus:outline-none focus:bg-white focus:bg-opacity-10 leading-tight font-bold py-6 flex justify-between gap-2">
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
