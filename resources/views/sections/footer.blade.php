<x-marquee :hide_marquee="$hide_marquee ?? false" />

<footer class="type-xs relative">
    <div class="bg-black py-12 text-gray-light">
        <div class="container grid grid-cols-2 gap-x-4 gap-y-12 lg:grid-cols-4 lg:gap-x-8 xl:gap-y-16">

            <div
                class="col-span-2 lg:col-span-1 text-center lg:text-left lg:order-none flex justify-center -order-2 flex-col gap-6">

                <div class="lg:mb-16 w-full flex flex-row justify-center gap-4 py-1 lg:justify-start xl:items-start">
                    @foreach (['facebook', 'twitter', 'youtube', 'instagram', 'linkedin', 'vimeo'] as $account)
                        <x-social-icon :account="$account" />
                    @endforeach
                </div>

                @if (isset($settings['address']))
                    <div>
                        <h3 class="font-bold text-white">Find us at:</h3>
                        <p class="">{{ $settings['address'] }}</p>
                    </div>
                @endif

                @if (isset($settings['phone']))
                    <div>
                        <h3 class="font-bold text-white">Box office:</h3>
                        <p>
                            <a class="" href="tel:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a>
                        </p>
                    </div>
                @endif

                @if (isset($settings['email_addresses']))
                    <div>
                        <h3 class="font-bold text-white">Email us:</h3>
                        @foreach ($settings['email_addresses'] as $name => $email)
                            <p><a class="" href="mailto:{{ $email }}">{{ $name }}</a></p>
                        @endforeach
                    </div>
                @endif

            </div>
            <div class="col-span-1">

            </div>
            <div class="-order-1 col-span-2 lg:-order-none mx-auto w-full max-w-xl lg:mx-0">
                <h3
                    class="type-regular lg:type-xs max-w-xs mx-auto lg:max-w-none text-center lg:text-left text-yellow font-bold lg:text-white">
                    {!! $settings['newsletter_heading'] ?? 'Newsletter' !!}<span class="hidden lg:inline">:</span></h3>

                <form action="{!! $settings['newsletter_action'] ??
                    'https://system.spektrix.com/leedsheritagetheatres/website/secure/signup.aspx' !!}" method="POST" class="mt-8 grid grid-cols-2 gap-x-4 gap-y-4">
                    <div class="relative z-0 mt-6">
                        <input type="text" id="firstNameSubscribe" name="FirstName" required maxlength="30"
                            class="peer block w-full border-b border-gray-dark bg-transparent pb-2 focus-within:border-white focus-within:outline-none"
                            placeholder=" " />
                        <label for="firstNameSubscribe"
                            class="peer-focus:text-white absolute duration-300 transform -translate-y-full pb-2 top-0 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-full">First
                            name<sup>*</sup></label>
                    </div>
                    <div class="relative z-0 mt-6">
                        <input type="text" id="lastNameSubscribe" name="LastName" required maxlength="80"
                            class="peer block w-full border-b border-gray-dark bg-transparent pb-2 focus-within:border-white focus-within:outline-none"
                            placeholder=" " />
                        <label for="lastNameSubscribe"
                            class="peer-focus:text-white absolute duration-300 transform -translate-y-full pb-2 top-0 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-full">Last
                            name<sup>*</sup></label>
                    </div>
                    <div class="relative z-0 col-span-2 mt-6">
                        <input type="email" id="emailSubscribe" name="Email" required maxlength="255"
                            class="peer block w-full border-b border-gray-dark bg-transparent pb-2 focus-within:border-white focus-within:outline-none"
                            placeholder=" " />
                        <label for="emailSubscribe"
                            class="peer-focus:text-white absolute duration-300 transform -translate-y-full pb-2 top-0 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-full">Email<sup>*</sup></label>
                    </div>
                    <input type="hidden" name="ReturnUrl"
                        value="{{ isset($settings['newsletter_redirect']) ? url($settings['newsletter_redirect']) : url('/signed-up') }}">
                    <div class="col-span-2 mt-8 flex flex-row items-center gap-2 max-w-md">
                        <input class="mt-0.5 h-3 w-3 appearance-none rounded-full border bg-gray-dark checked:bg-yellow"
                            id="consent" name="consent" type="checkbox">
                        <label for="consent" class="text-xs inline-block text-white">
                            I agree to the HPPH Privacy Policy.</label>

                        <button aria-label="Submit" type="submit"
                            class="w-9 block bg-gray-dark ml-auto rounded-full text-white">
                            @svg('arrow-right', 'h-9 w-9 p-2 transform -rotate-45')
                        </button>
                    </div>

                </form>
            </div>
            <div
                class="col-span-2 lg:mt-6 flex flex-row justify-center lg:justify-start flex-nowrap items-center gap-x-3 gap-y-5 lg:flex-nowrap lg:gap-4">
                @svg('logo-hlf2', 'text-gray-light w-24 h-auto')
                @svg('logo-filmhub', 'text-gray-light w-14 h-auto')
                @svg('logo-bfi', 'text-gray-light w-40 h-auto')
                @svg('logo-lcc', 'text-gray-light w-20 h-auto')
                @svg('logo-gwf', 'text-gray-light w-20 h-auto')
                @svg('logo-fundraising_regulator', 'text-gray-light w-28 h-auto')
            </div>

            <div class="lg:col-span-1 col-span-2 self-end text-center lg:text-left order-last lg:-order-none">
                <p class="text-xs">Copyright Hyde Park Picture House {{ date('Y') }}</p>
                @if (isset($settings['charity_number']))
                    <p class="text-xs">Registered Charity No.{{ $settings['charity_number'] }}</p>
                @endif
                <p class="text-xs">Site design by <a href="https://rabbithole.co.uk/" class="text-white"
                        target="_blank">Rabbithole&#174;</a>. Build by <a class="text-white"
                        href="https://letsdance.agency/" target="_blank">Let’s Dance</a></p>
            </div>

            <div
                class="col-span-2 lg:col-span-1 flex flex-row justify-center lg:justify-start items-center gap-2 self-end">
                <a target="_blank" class="text-white" href="https://leedsheritagetheatres.com/">@svg('logo-lht', 'w-28 h-auto')</a>
                @svg('logo-hpph', 'text-white w-24 h-auto')
            </div>

        </div>
    </div>

</footer>
