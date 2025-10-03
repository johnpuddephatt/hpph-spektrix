<x-marquee :hide_marquee="$hide_marquee ?? false" />

<footer class="type-xs relative">
    <div class="bg-black py-12 text-gray-light">
        <div class="container grid grid-cols-2 gap-x-4 gap-y-12 lg:grid-cols-4 lg:gap-x-8 xl:gap-y-16">

            <div
                class="-order-2 col-span-2 flex flex-col justify-center gap-6 text-center lg:order-none lg:col-span-1 lg:text-left">

                <div class="flex w-full flex-row justify-center gap-4 py-1 lg:mb-16 lg:justify-start xl:items-start">
                    @foreach (['facebook', 'twitter', 'youtube', 'instagram', 'linkedin', 'vimeo'] as $account)
                        <x-social-icon :account="$account" />
                    @endforeach
                </div>

                @if (isset($settings['address']))
                    <div>
                        <h3 class="font-bold text-white">Find us at:</h3>
                        <a target="_blank"
                            href="https://www.google.co.uk/maps/place/Hyde+Park+Picture+House/@53.8121105,-1.5719085,17z/data=!3m1!4b1!4m6!3m5!1s0x48795eb36ea31d3b:0x2b8f7b787dcc4b35!8m2!3d53.8121105!4d-1.5693336!16zL20vMDg3MjN2?entry=ttu"
                            class="transition hover:text-yellow">{{ $settings['address'] }}</a>
                    </div>
                @endif

                @if (isset($settings['phone']))
                    <div>
                        <h3 class="font-bold text-white">Box office:</h3>
                        <p>
                            <a class="transition hover:text-yellow"
                                href="tel:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a>
                        </p>
                    </div>
                @endif

                @if (isset($settings['email_addresses']))
                    <div>
                        <h3 class="font-bold text-white">Email us:</h3>
                        @foreach ($settings['email_addresses'] as $name => $email)
                            <p><a class="transition hover:text-yellow"
                                    href="mailto:{{ $email }}">{{ $name }}</a></p>
                        @endforeach
                    </div>
                @endif

            </div>
            <div class="col-span-1">

            </div>
            <div class="-order-1 col-span-2 mx-auto w-full max-w-xl lg:-order-none lg:mx-0">
                <h3
                    class="type-regular lg:type-xs mx-auto max-w-xs text-center font-bold text-yellow lg:max-w-none lg:text-left lg:text-white">
                    {!! $settings['newsletter_heading'] ?? 'Newsletter' !!}<span class="hidden lg:inline">:</span></h3>

                <form action="{!! $settings['newsletter_action'] ??
                    'https://system.spektrix.com/leedsheritagetheatres/website/secure/signup.aspx' !!}" method="POST" class="mt-8 grid grid-cols-2 gap-x-4 gap-y-4">
                    <div class="relative z-0 mt-6">
                        <input type="text" id="firstNameSubscribe" name="FirstName" required maxlength="30"
                            class="peer block w-full border-b border-gray-dark bg-transparent pb-2 focus-within:border-white focus-within:outline-none"
                            placeholder=" " />
                        <label for="firstNameSubscribe"
                            class="absolute top-0 -z-10 origin-[0] -translate-y-full transform pb-2 duration-300 peer-placeholder-shown:translate-y-0 peer-focus:left-0 peer-focus:-translate-y-full peer-focus:text-white">First
                            name<sup>*</sup></label>
                    </div>
                    <div class="relative z-0 mt-6">
                        <input type="text" id="lastNameSubscribe" name="LastName" required maxlength="80"
                            class="peer block w-full border-b border-gray-dark bg-transparent pb-2 focus-within:border-white focus-within:outline-none"
                            placeholder=" " />
                        <label for="lastNameSubscribe"
                            class="absolute top-0 -z-10 origin-[0] -translate-y-full transform pb-2 duration-300 peer-placeholder-shown:translate-y-0 peer-focus:left-0 peer-focus:-translate-y-full peer-focus:text-white">Last
                            name<sup>*</sup></label>
                    </div>
                    <div class="relative z-0 col-span-2 mt-6">
                        <input type="email" id="emailSubscribe" name="Email" required maxlength="255"
                            class="peer block w-full border-b border-gray-dark bg-transparent pb-2 focus-within:border-white focus-within:outline-none"
                            placeholder=" " />
                        <label for="emailSubscribe"
                            class="absolute top-0 -z-10 origin-[0] -translate-y-full transform pb-2 duration-300 peer-placeholder-shown:translate-y-0 peer-focus:left-0 peer-focus:-translate-y-full peer-focus:text-white">Email<sup>*</sup></label>
                    </div>
                    <input type="hidden" name="ReturnUrl"
                        value="{{ isset($settings['newsletter_redirect']) ? url($settings['newsletter_redirect']) : url('/signed-up') }}">
                    <div class="col-span-2 mt-8 flex max-w-md flex-row items-center gap-2">
                        <input
                            class="mt-0.5 h-3 w-3 appearance-none rounded-full border bg-gray-dark transition checked:bg-yellow hover:border-yellow"
                            id="consent" name="consent" type="checkbox">
                        <label for="consent" class="inline-block text-xs text-white">
                            I agree to the HPPH <a target="_blank" class="underline" href="/privacy">Privacy
                                Policy</a>.</label>

                        <button aria-label="Submit" type="submit"
                            class="ml-auto block w-9 rounded-full bg-gray-dark text-white">
                            @svg('arrow-right', 'h-9 w-9 p-2 transform -rotate-45')
                        </button>
                    </div>

                </form>
            </div>
            <div
                class="col-span-2 flex flex-row flex-wrap items-center justify-center gap-x-4 gap-y-6 lg:mt-6 lg:justify-start lg:gap-8">
                @svg('logo-hlf2', 'text-gray-light w-32 h-auto')
                @svg('logo-lcc', 'text-gray-light w-32 h-auto')
                @svg('logo-fundedbyukgovernment', 'text-gray-light w-40 h-auto')
                @svg('logo-wyca', 'text-gray-light w-44 h-auto')
                @svg('logo-filmhub', 'text-gray-light w-16 h-auto')
                @svg('logo-bfi', 'text-gray-light w-48 h-auto')

                @svg('logo-gwf', 'text-gray-light w-24 h-auto')
                @svg('logo-fundraising_regulator', 'text-gray-light w-36 h-auto')

            </div>

            <div class="order-last col-span-2 self-end text-center lg:-order-none lg:col-span-1 lg:text-left">
                <p class="text-xs">Copyright Hyde Park Picture House {{ date('Y') }}</p>
                @if (isset($settings['charity_number']))
                    <p class="text-xs">Registered Charity No.{{ $settings['charity_number'] }}</p>
                @endif
                <p class="text-xs">Site design by <a href="https://rabbithole.co.uk/"
                        class="text-white transition hover:text-yellow" target="_blank">Rabbithole&#174;</a>. Build by
                    <a class="text-white transition hover:text-yellow" href="https://letsdance.agency/"
                        target="_blank">Let’s Dance</a>
                </p>
            </div>

            <div
                class="col-span-2 flex flex-row items-center justify-center gap-2 self-end lg:col-span-1 lg:justify-start">
                <a target="_blank" class="text-white transition hover:text-yellow"
                    href="https://leedsheritagetheatres.com/">@svg('logo-lht', 'w-28 h-auto')</a>
                @svg('logo-hpph', 'text-white w-24 h-auto')
            </div>

        </div>
    </div>

</footer>
