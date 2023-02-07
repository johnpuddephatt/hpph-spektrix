<div class="text-black isolate bg-white relative">
    <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]">
        <svg class="relative left-[calc(50%-11rem)] -z-10 h-[21.1875rem] max-w-none -translate-x-1/2 rotate-[30deg] sm:left-[calc(50%-30rem)] sm:h-[42.375rem]"
            viewBox="0 0 1155 678" xmlns="http://www.w3.org/2000/svg">
            <path fill="url(#45de2b6b-92d5-4d68-a6a0-9b9b2abad533)" fill-opacity=".3"
                d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
            <defs>
                <linearGradient id="45de2b6b-92d5-4d68-a6a0-9b9b2abad533" x1="1155.49" x2="-78.208" y1=".177"
                    y2="474.645" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#9089FC"></stop>
                    <stop offset="1" stop-color="#FF80B5"></stop>
                </linearGradient>
            </defs>
        </svg>
    </div>
    <div class="px-6 pt-6 lg:px-8">
        <nav class="flex items-center justify-between" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                        alt="">
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button"
                    class="rounded-md text-gray-700 -m-2.5 inline-flex items-center justify-center p-2.5">
                    <span class="sr-only">Open main menu</span>
                    <!-- Heroicon name: outline/bars-3 -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="#" class="text-gray-900 text-sm font-semibold leading-6">Product</a>

                <a href="#" class="text-gray-900 text-sm font-semibold leading-6">Features</a>

                <a href="#" class="text-gray-900 text-sm font-semibold leading-6">Marketplace</a>

                <a href="#" class="text-gray-900 text-sm font-semibold leading-6">Company</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <a href="#" class="text-gray-900 text-sm font-semibold leading-6">Log in <span
                        aria-hidden="true">&rarr;</span></a>
            </div>
        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div role="dialog" aria-modal="true">
            <div focus="true" class="fixed inset-0 z-10 overflow-y-auto bg-white px-6 py-6 md:hidden">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                            alt="">
                    </a>
                    <button type="button" class="rounded-md text-gray-700 -m-2.5 p-2.5">
                        <span class="sr-only">Close menu</span>
                        <!-- Heroicon name: outline/x-mark -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="divide-gray-500/10 -my-6 divide-y">
                        <div class="space-y-2 py-6">
                            <a href="#"
                                class="rounded-lg text-gray-900 hover:bg-gray-400/10 -mx-3 block py-2 px-3 text-base font-semibold leading-7">Product</a>

                            <a href="#"
                                class="rounded-lg text-gray-900 hover:bg-gray-400/10 -mx-3 block py-2 px-3 text-base font-semibold leading-7">Features</a>

                            <a href="#"
                                class="rounded-lg text-gray-900 hover:bg-gray-400/10 -mx-3 block py-2 px-3 text-base font-semibold leading-7">Marketplace</a>

                            <a href="#"
                                class="rounded-lg text-gray-900 hover:bg-gray-400/10 -mx-3 block py-2 px-3 text-base font-semibold leading-7">Company</a>
                        </div>
                        <div class="py-6">
                            <a href="#"
                                class="rounded-lg text-gray-900 hover:bg-gray-400/10 -mx-3 block py-2.5 px-3 text-base font-semibold leading-6">Log
                                in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main>
        <div class="relative px-6 lg:px-8">
            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                @if (isset($image))
                    <img src="{{ Storage::disk('public')->url($image) }}"
                        class="object-fit block mx-auto mb-8 bg-gray object-cover w-64 h-64 rounded-full" />
                @endif
                <div class="hidden sm:mb-8 sm:flex sm:justify-center">

                    <div
                        class="text-gray-600 hover:ring-gray-900/20 ring-gray relative rounded-full py-1 px-3 text-sm leading-6 ring-1">
                        Announcing our next round of funding. <a href="#"
                            class="text-indigo-600 font-semibold"><span class="absolute inset-0"
                                aria-hidden="true"></span>Read more <span aria-hidden="true">&rarr;</span></a>
                    </div>

                </div>
                <div class="text-center">
                    <h1 class="tracking-tight text-gray-900 text-4xl font-bold sm:text-6xl">{{ $title }}</h1>
                    <p class="text-gray-600 mt-6 text-lg leading-8">{{ $introduction }}</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="#"
                            class="hover:bg-indigo-500 focus-visible:outline-indigo-600 rounded bg-[#4e46dd] px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">Get
                            started</a>
                        <a href="#" class="text-gray-900 text-base font-semibold leading-7">Learn more <span
                                aria-hidden="true">→</span></a>
                    </div>
                </div>
            </div>
            <div
                class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <svg class="relative left-[calc(50%+3rem)] h-[21.1875rem] max-w-none -translate-x-1/2 sm:left-[calc(50%+36rem)] sm:h-[42.375rem]"
                    viewBox="0 0 1155 678" xmlns="http://www.w3.org/2000/svg">
                    <path fill="url(#ecb5b0c9-546c-4772-8c71-4d3f06d544bc)" fill-opacity=".3"
                        d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
                    <defs>
                        <linearGradient id="ecb5b0c9-546c-4772-8c71-4d3f06d544bc" x1="1155.49" x2="-78.208"
                            y1=".177" y2="474.645" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#9089FC"></stop>
                            <stop offset="1" stop-color="#FF80B5"></stop>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
        </div>
    </main>
</div>
