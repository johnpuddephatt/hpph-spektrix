{{-- "On this page" menu. Rendered when the page has display_menu switched on
     and has at least one block that can label itself — see Page::menuLinks(). --}}
@php($links = $page->menuLinks())

@if ($links->isNotEmpty())
    <div class="border-b border-black-light bg-black text-white" x-data="{ activeSection: null }" x-init="activeSection = window.location.hash.replace('#', '')">

        <div class="overflow-x-scroll py-6 scrollbar-hide">
            <div class="justify-center-safe flex flex-row gap-8 px-8">
                <div class="type-xs-mono whitespace-nowrap">Jump to:</div>
                @foreach ($links as $layout)
                    <a @click="activeSection = section" x-data="{ section: '{{ $layout->menuAnchor() }}' }" class="type-small whitespace-nowrap"
                        :href="`#${section}`" :class="{ 'underline': activeSection == section }">
                        {{ $layout->menuLabel() }}
                    </a>
                @endforeach
                &nbsp;&nbsp;&nbsp;
            </div>
        </div>
    </div>
@endif
