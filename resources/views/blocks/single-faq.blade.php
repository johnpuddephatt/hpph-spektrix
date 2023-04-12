<details v-for="faq in faqs"
    class="@if ($dark) border-gray-dark @else border-sand-dark @endif border-t first:border-t-0">
    <summary style="color: @yield('color')"
        class="group lg:type-regular @if ($dark) focus:bg-white text-yellow @else focus:bg-sand-dark @endif focus-visible:outline-none focus:outline-none focus:bg-opacity-10 leading-tight font-bold py-6 flex items-center justify-between gap-2">
        <div class="@if ($dark) group-hover:text-[inherit] text-white @endif">
            {{ $layout->question }}</div>
        @svg('plus', 'block text-inherit w-6 h-6')

    </summary>
    @if ($layout->answer)
        <x-editorjs :content="$layout->answer" class="py-4" block_class="mx-0" />
    @endif
</details>
