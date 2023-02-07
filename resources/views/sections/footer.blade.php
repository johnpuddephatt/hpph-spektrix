@include('sections.marquee')

<footer class="relative">
    <div class="bg-black py-12 text-gray-light">
        <div class="container grid grid-cols-2 gap-x-4 gap-y-16 lg:grid-cols-4 lg:gap-x-16 xl:gap-y-16">

            <div class="flex flex-col gap-6">

                <div class="mb-16 flex flex-row justify-center gap-4 py-1 lg:justify-start xl:items-start">
                    @foreach (['facebook', 'twitter', 'youtube', 'instagram', 'linkedin', 'vimeo'] as $account)
                        <x-social-icon :account="$account" />
                    @endforeach
                </div>

                @if (isset($settings['address']))
                    <div>
                        <h3 class="text-sm font-bold text-white">Find us at:</h3>
                        <p class="text-sm">{{ $settings['address'] }}</p>
                    </div>
                @endif

                @if (isset($settings['phone']))
                    <div>
                        <h3 class="text-sm font-bold text-white">Box office:</h3>
                        <p>
                            <a class="text-sm" href="tel:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a>
                        </p>
                    </div>
                @endif

                @if (isset($settings['email_addresses']))
                    <div>
                        <h3 class="font-bold text-white text-sm">Email us:</h3>
                        @foreach ($settings['email_addresses'] as $name => $email)
                            <p><a class="text-sm" href="mailto:{{ $email }}">{{ $name }}</a></p>
                        @endforeach
                    </div>
                @endif

            </div>
            <div class="col-span-1">

            </div>
            <div class="-order-1 col-span-2 lg:-order-none lg:max-w-xl">
                <h3 class="text-sm font-bold text-white">Newsletter:</h3>

                <form class="mt-16 grid grid-cols-2">
                    <div class="">
                        <label class="text-sm my-2 block" for="first_name">First name<sup>*</sup></label>
                        <input
                            class="text-sm block w-full border-b-2 border-transparent bg-transparent py-1 px-0 focus-within:border-white focus-within:outline-none"
                            type="text" id="first_name" name="first_name" />
                    </div>
                    <div class="">
                        <label class="text-sm my-2 ml-4 block" for="last_name">Last name<sup>*</sup></label>
                        <input
                            class="text-sm block w-full border-b-2 border-transparent bg-transparent py-1 px-2 pl-4 focus-within:border-white focus-within:outline-none"
                            type="text" id="last_name" name="last_name" />
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm my-2 block" for="email">Email <sup>*</sup></label>
                        <input
                            class="text-sm block w-full border-b-2 border-transparent bg-transparent py-1 px-0 focus-within:border-white focus-within:outline-none"
                            type="text" id="email" name="email" />
                    </div>
                    <div class="mt-8 flex flex-row items-start gap-2">
                        <input class="mt-0.5 h-3 w-3 appearance-none rounded-full border bg-gray-dark checked:bg-yellow"
                            id="consent" name="consent" type="checkbox">
                        <label for="consent" class="text-xs inline-block w-48 text-white">
                            I agree to the HPPH Privacy Policy.</label>
                    </div>
                    <button aria-label="Submit" type="submit"
                        class="w-10 mt-4 p-2 bg-gray-dark rounded-full text-white">
                        @svg('arrow-right', 'h-6 w-6 transform -rotate-45')
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

            <div class="col-span-1 self-center">
                <p class="text-xs">Copyright Hyde Park Picture House 2022</p>
                @if (isset($settings['charity_number']))
                    <p class="text-xs">Registered Charity No.{{ $settings['charity_number'] }}</p>
                @endif
                <p class="text-xs">Site design by <a href="https://rabbithole.co.uk/" class="text-white"
                        target="_blank">Rabbithole&#174;</a>. Build by <a class="text-white"
                        href="https://letsdance.agency/" target="_blank">Let’s Dance</a></p>
            </div>

            <div class="flex flex-row items-center gap-2 justify-self-end lg:justify-self-auto">
                <a target="_blank" class="text-white" href="https://leedsheritagetheatres.com/">@svg('logo-lht', 'w-28 h-auto')</a>
                @svg('logo-full', 'hidden lg:block text-white w-24 h-auto')
            </div>

            @env('local')
            <x-login-link class="rounded bg-white bg-opacity-25 px-4 py-2" email="john@letsdance.agency" label="Login"
                redirect-url="{{ route('nova.pages.home') }}" />
            @endenv
        </div>
    </div>

</footer>
