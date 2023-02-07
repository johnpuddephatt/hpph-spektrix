<div class="container">
    @if ($paginator->hasPages())
        @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : ($this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1))

        <nav role="navigation" aria-label="Pagination Navigation" class="my-12 flex items-center justify-between">
            <div class="flex flex-1 justify-between sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span
                            class="relative inline-flex cursor-default select-none items-center rounded border border-gray-light bg-white px-2 py-1 font-medium text-gray-light">
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <button wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                            class="text-gray-700 border-gray-300 hover:text-gray-500 focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 relative inline-flex items-center rounded border border-gray-light bg-white px-2 py-1 font-medium transition duration-150 ease-in-out focus:outline-none">
                            {!! __('pagination.previous') !!}
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                            class="text-gray-700 border-gray-300 hover:text-gray-500 focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 relative ml-3 inline-flex items-center rounded border border-gray-light bg-white px-2 py-1 font-medium transition duration-150 ease-in-out focus:outline-none">
                            {!! __('pagination.next') !!}
                        </button>
                    @else
                        <span
                            class="relative ml-3 inline-flex cursor-default select-none items-center rounded border border-gray-light bg-white px-2 py-1 font-medium text-gray-light">
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>

            <div class="hidden sm:block">

                <div>
                    <span class="relative z-0 inline-flex gap-2">
                        <span>
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                    <span
                                        class="relative inline-flex h-12 w-12 cursor-default items-center justify-center rounded-full border border-gray border-gray-light bg-white font-medium text-gray"
                                        aria-hidden="true">
                                        @svg('chevron-right', 'w-5 h-5 rotate-180 origin-center')
                                    </span>
                                </span>
                            @else
                                <button wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                    dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                    rel="prev"
                                    class="text-gray-500 border-gray-300 hover:text-gray-400 focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 relative inline-flex h-12 w-12 items-center justify-center rounded-full border border-gray-light bg-white font-medium transition duration-150 ease-in-out focus:z-10 focus:outline-none"
                                    aria-label="{{ __('pagination.previous') }}">
                                    @svg('chevron-right', 'w-5 h-5 rotate-180 origin-center')
                                </button>
                            @endif
                        </span>

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span
                                        class="text-gray-700 border-gray-300 relative inline-flex h-12 w-12 cursor-default select-none items-center justify-center rounded-full border border-gray-light bg-white font-medium">{{ $element }}</span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span
                                        wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page{{ $page }}">
                                        @if ($page == $paginator->currentPage())
                                            <span aria-current="page">
                                                <span
                                                    class="text-gray-500 border-gray-300 relative inline-flex h-12 w-12 cursor-default select-none items-center justify-center rounded-full border border-yellow bg-yellow text-center font-medium">{{ $page }}</span>
                                            </span>
                                        @else
                                            <button
                                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                                class="text-gray-700 border-gray-300 hover:text-gray-500 focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 relative inline-flex h-12 w-12 items-center justify-center rounded-full border border-gray-light bg-white font-medium transition duration-150 ease-in-out focus:z-10 focus:outline-none"
                                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                                {{ $page }}
                                            </button>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                        <span>
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <button wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                    dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                    rel="next"
                                    class="text-gray-500 border-gray-300 hover:text-gray-400 focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 relative inline-flex h-12 w-12 items-center justify-center rounded-full border border-gray-light bg-white text-center font-medium transition duration-150 ease-in-out focus:z-10 focus:outline-none"
                                    aria-label="{{ __('pagination.next') }}">
                                    @svg('chevron-right', 'w-5 h-5')
                                </button>
                            @else
                                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                    <span
                                        class="relative inline-flex h-12 w-12 cursor-default items-center justify-center rounded-full border border-gray bg-white font-medium text-gray"
                                        aria-hidden="true">
                                        @svg('chevron-right', 'w-5 h-5')
                                    </span>
                                </span>
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
