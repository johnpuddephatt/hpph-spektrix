    <div class="grid container grid-cols-2 bg-black text-white py-16">

        <h3 class="type-regular py-6" style="color: @yield('color')">
            {{ $layout->title }}</h3>

        <div class="divide-y divide-gray-dark">

            @foreach ($layout->faqs as $faq)
                <details v-for="faq in faqs">
                    <summary style="color: @yield('color')"
                        class="group lg:type-regular container focus-visible:outline-none focus:outline-none focus:bg-white focus:bg-opacity-10 leading-tight font-bold py-6 flex items-center justify-between gap-2">
                        <div class="group-hover:text-[inherit] text-white">{{ $faq->question }}</div>
                        @svg('plus', 'text-white w-6 h-6')

                    </summary>
                    @if ($faq->answer)
                        <x-editorjs :content="$faq->answer" class="py-4 px-6" block_class="mx-0" />
                    @endif
                </details>
            @endforeach

        </div>
    </div>
