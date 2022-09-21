<footer class="relative">
    <div class="bg-yellow py-6">
        <div class="container items-center gap-16 lg:flex">
            <div class="flex flex-row justify-center gap-4 py-1 lg:w-1/2 lg:justify-start xl:items-start">
                @foreach (['facebook', 'twitter', 'youtube', 'instagram', 'linkedin', 'vimeo'] as $account)
                    @if (isset($settings[$account]))
                        <a title="Visit our {{ $account }} account"
                            class="inline-block rounded-full bg-black p-2 text-yellow" target="_blank"
                            href="{{ $settings[$account] }}">@svg($account, 'h-5 w-5')</a>
                    @endif
                @endforeach
            </div>

            @if (isset($settings['opening_hours']))
                <div class="lg:w-1/2">
                    <div class="flex-row gap-12 lg:flex lg:max-w-2xl">
                        <h3
                            class="mx-auto mt-4 mb-2 text-center font-bold lg:mx-0 lg:mt-0 lg:mb-0 lg:w-1/2 lg:text-left">
                            Opening hours</h3>
                        <div class="mx-auto max-w-xs lg:mx-0 lg:w-1/2">
                            @foreach ($settings['opening_hours'] as $day => $hours)
                                <div class="flex flex-row gap-12 lg:gap-4">
                                    <div class="w-1/2 lg:w-1/3">{{ $day }}:</div>
                                    <div class="w-1/2 lg:w-2/3">{{ $hours }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <div class="bg-black py-12 text-gray-light">
        <div class="container grid grid-cols-2 gap-x-4 gap-y-16 lg:grid-cols-4 lg:gap-x-16 xl:gap-y-16">
            <div class="flex flex-col gap-6">
                @if (isset($settings['phone']))
                    <div>
                        <h3 class="font-bold text-white">Box office</h3>
                        <p>
                            <a href="tel:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a>
                        </p>
                    </div>
                @endif

                @if (isset($settings['address']))
                    <div>
                        <h3 class="font-bold text-white">Address</h3>
                        <p>{{ $settings['address'] }}</p>
                    </div>
                @endif

                @if (isset($settings['email_addresses']))
                    <div>
                        <h3 class="font-bold text-white">Email us</h3>
                        @foreach ($settings['email_addresses'] as $name => $email)
                            <p><a href="mailto:{{ $email }}">{{ $name }}</a></p>
                        @endforeach
                    </div>
                @endif

            </div>
            <div class="col-span-1">
                @if ($footer_menu)
                    <h3 class="mb-4 font-bold text-white">Learn more</h3>
                    <nav>
                        <ul class="">
                            @foreach ($footer_menu as $menu_item)
                                <li>
                                    <a href="{{ $menu_item['value'] }}">{{ $menu_item['name'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                @endif

            </div>
            <div class="-order-1 col-span-2 row-span-2 lg:-order-none lg:max-w-xl">
                <h3 class="font-bold text-white">Be the first to hear about the latest news, screenings and special live
                    events</h3>

                <form class="mt-16 grid grid-cols-2 border-t">
                    <div class="border-b">
                        <label class="my-2 block" for="first_name">First Name<sup>*</sup></label>
                        <input
                            class="block w-full border-b-2 border-transparent bg-transparent py-1 px-0 focus-within:border-white focus-within:outline-none"
                            type="text" id="first_name" name="first_name" />
                    </div>
                    <div class="border-l border-b">
                        <label class="my-2 ml-4 block" for="last_name">Last Name<sup>*</sup></label>
                        <input
                            class="block w-full border-b-2 border-transparent bg-transparent py-1 px-2 pl-4 focus-within:border-white focus-within:outline-none"
                            type="text" id="last_name" name="last_name" />
                    </div>
                    <div class="col-span-2 border-b">
                        <label class="my-2 block" for="email">Email <sup>*</sup></label>
                        <input
                            class="block w-full border-b-2 border-transparent bg-transparent py-1 px-0 focus-within:border-white focus-within:outline-none"
                            type="text" id="email" name="email" />
                    </div>
                    <div class="mt-16 flex flex-row items-start gap-2">
                        <input class="mt-1 h-3 w-3 appearance-none rounded-full border border-yellow checked:bg-yellow"
                            id="consent" name="consent" type="checkbox">
                        <label for="consent" class="inline-block w-48 text-white">
                            I have read and agree to the HPPH Privacy Policy.</label>
                    </div>
                    <button type="submit" class="mt-16 rounded border text-white">
                        Submit
                    </button>

                </form>
            </div>
            <div
                class="col-span-2 mt-6 flex flex-row flex-wrap items-center gap-x-3 gap-y-5 border-t-[0.5px] border-gray-medium pt-6 lg:mt-0 lg:flex-nowrap lg:gap-4 lg:border-t-0">
                @svg('logo-hlf', 'text-gray w-24 h-auto')
                @svg('logo-filmhub', 'text-gray w-14 h-auto')
                @svg('logo-bfi', 'text-gray w-40 h-auto')
                @svg('logo-lcc', 'text-gray w-20 h-auto')
                @svg('logo-gwf', 'text-gray w-20 h-auto')
                @svg('logo-fundraising_regulator', 'text-gray w-28 h-auto')

            </div>
            <div class="flex flex-row items-center gap-2 justify-self-end lg:justify-self-auto">
                <a target="_blank" class="text-white" href="https://leedsheritagetheatres.com/">@svg('logo-lht', 'w-28 h-auto')</a>
                @svg('logo-full', 'hidden lg:block text-white w-24 h-auto')
            </div>
            <div class="self-center">
                <p class="text-xs">Part of Leeds Heritage Theatres</p>
                @if (isset($settings['charity_number']))
                    <p class="text-xs">Registered Charity No.{{ $settings['charity_number'] }}</p>
                @endif
            </div>
            <div class="col-span-2 self-center">
                <p class="text-xs">Copyright Hyde Park Picture House 2022</p>
                <p class="text-xs">Site design by Rabbithole&#174;, Build by Let’s Dance</p>

            </div>
            @env('local')
            <x-login-link class="rounded bg-white bg-opacity-25 px-4 py-2" email="john@letsdance.agency" label="Login"
                redirect-url="{{ route('nova.pages.home') }}" />
            @endenv
        </div>
    </div>

</footer>
