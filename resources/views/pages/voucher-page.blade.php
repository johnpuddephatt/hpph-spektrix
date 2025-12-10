@push('webComponents', '#spektrix-gift-vouchers')
@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page->id])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@section('content')
    <div class="fixed inset-0 -z-10 h-[75vh] bg-black lg:h-screen lg:w-1/2">

        @if ($page->mainImage)
            {{ $page->mainImage->img('square')->attributes(['class' => 'h-full w-full object-cover']) }}
        @endif
    </div>

    <div x-data="{ deliveryType: 'CustomerEmail' }" class="relative mt-[75vh] min-h-screen bg-sand lg:ml-[50%] lg:mt-0">

        <div class="flex flex-col bg-sand-light pb-12 pt-6 lg:h-[66.6vh]">
            <div class="container">
                <a class="type-xs-mono relative z-50 mb-4 inline-block rounded border-2 border-transparent py-2 pl-1 pr-4 uppercase hover:border-sand"
                    href="{{ \App\Models\Page::getTemplateUrl('shop-page') }}">@svg('chevron-right', ' align-top h-4 w-4 inline-block transform rotate-180 origin-center')
                    Back </a>
            </div>
            <div class="container my-auto ml-0 max-w-2xl">
                <h2 class="type-medium lg:type-large">{{ $page->name }}</h2>
                <p class="type-regular lg:type-medium mt-6 !font-normal">{{ $page->subtitle }}</p>
            </div>
            <div class="type-regular container ml-0 max-w-2xl pt-12 !font-normal">
                {{ $page->introduction }}
            </div>
        </div>

        <spektrix-gift-vouchers x-data="{ amount: 25 }" x-init="$el.giftVoucherAmount = amount;
        setTimeout(() => { $el.giftVoucherAmount = amount }, 1000)" x-effect="$el.giftVoucherAmount = amount"
            client-name="{{ $settings['spektrix_client_name'] }}" custom-domain="{{ $settings['spektrix_custom_domain'] }}">

            <div class="container py-4 lg:pb-24">

                <div class="max-w-2xl border-b border-sand-dark py-8">
                    <div class="type-regular mb-4">
                        <span class="inline-block h-10 w-10 rounded-full bg-yellow p-2 text-center">1</span>
                        Choose amount
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">
                        <input type="number" id="amount" name="amount" data-amount value="25"
                            class="peer block w-full rounded border border-transparent bg-sand-light px-4 pb-2 pl-7 pt-6 focus-within:border-white focus-within:outline-none"
                            placeholder=" " />

                        {{-- <input type="number" id="amount" name="amount" x-model="amount"
                            class="peer block w-full rounded border border-transparent bg-sand-light px-4 pb-2 pl-7 pt-6 focus-within:border-white focus-within:outline-none"
                            placeholder=" " /> --}}

                        <label for="amount"
                            class="pointer-events-none absolute left-4 top-0 z-10 origin-top-left -translate-y-0.5 scale-75 transform py-4 text-gray-medium duration-300 peer-placeholder-shown:translate-y-0.5 peer-placeholder-shown:scale-100 peer-focus:-translate-y-0.5 peer-focus:scale-75">Voucher
                            amount<sup>*</sup></label>

                        <span
                            class="absolute bottom-[0.55rem] left-4 opacity-100 peer-placeholder-shown:opacity-0 peer-focus:opacity-100">£</span>
                    </div>

                </div>

                <div class="max-w-2xl border-b border-sand-dark py-8">
                    <div class="type-regular mb-4">
                        <span class="inline-block h-10 w-10 rounded-full bg-yellow p-2 text-center">2</span>
                        Date to email voucher
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">
                        <input type="date" id="sendDate" name="sendDate" data-send-date
                            class="peer block w-full rounded border border-transparent bg-sand-light px-4 pb-2 pt-6 focus-within:border-white focus-within:outline-none"
                            placeholder=" " min="{{ date('Y-m-d') }}" />
                        <label for="sendDate"
                            class="pointer-events-none absolute left-4 top-0 z-10 origin-top-left -translate-y-0.5 scale-75 transform py-4 text-gray-medium duration-300 peer-placeholder-shown:translate-y-0.5 peer-placeholder-shown:scale-100 peer-focus:-translate-y-0.5 peer-focus:scale-75">Send
                            date</label>
                    </div>
                </div>

                <div class="max-w-2xl border-b border-sand-dark py-8">
                    <div class="type-regular mb-4">
                        <span class="inline-block h-10 w-10 rounded-full bg-yellow p-2 text-center">3</span>
                        Delivery email
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">

                        <label for="deliveryType"
                            class="pointer-events-none absolute left-4 top-0 z-10 origin-top-left -translate-y-0.5 scale-75 transform py-4 text-gray-medium duration-300 peer-placeholder-shown:translate-y-0.5 peer-placeholder-shown:scale-100 peer-focus:-translate-y-0.5 peer-focus:scale-75">Deliver
                            to</label>
                        <select
                            class="peer block w-full rounded border border-transparent bg-sand-light px-3 pb-2 pt-6 focus-within:border-white focus-within:outline-none"
                            @change="deliveryType = $event.target.value" name="deliveryType" data-delivery-type>
                            <option disabled selected value="">Select delivery type</option>
                            <option value="CustomerEmail">Your Email address</option>
                            <option value="OtherEmail">Another Email address</option>
                        </select>
                    </div>

                    <div x-show="deliveryType == 'OtherEmail'" class="relative z-0 mt-6 max-w-lg">

                        <input type="text" id="deliveryEmail" name="deliveryEmail" data-delivery-email-address
                            class="peer block w-full rounded border border-transparent bg-sand-light px-4 pb-2 pt-6 focus-within:border-white focus-within:outline-none"
                            placeholder=" " />

                        <label for="deliveryEmail"
                            class="pointer-events-none absolute left-4 top-0 z-10 origin-top-left -translate-y-0.5 scale-75 transform py-4 text-gray-medium duration-300 peer-placeholder-shown:translate-y-0.5 peer-placeholder-shown:scale-100 peer-focus:-translate-y-0.5 peer-focus:scale-75">Email
                            address to deliver to</label>

                    </div>

                </div>

                <div class="max-w-2xl border-b border-sand-dark py-8">
                    <div class="type-regular mb-4">
                        <span class="inline-block h-10 w-10 rounded-full bg-yellow p-2 text-center">4</span>
                        Add gift message
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">
                        <input type="text" id="toname" name="toname" data-to-name
                            class="peer block w-full rounded border border-transparent bg-sand-light px-4 pb-2 pt-6 focus-within:border-white focus-within:outline-none"
                            placeholder=" " />
                        <label for="toname"
                            class="pointer-events-none absolute left-4 top-0 z-10 origin-top-left -translate-y-0.5 scale-75 transform py-4 text-gray-medium duration-300 peer-placeholder-shown:translate-y-0.5 peer-placeholder-shown:scale-100 peer-focus:-translate-y-0.5 peer-focus:scale-75">Their
                            name</label>
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">
                        <textarea type="text" id="message" name="message" data-message
                            class="peer block w-full rounded border border-transparent bg-sand-light px-4 pb-2 pt-6 focus-within:border-white focus-within:outline-none"
                            placeholder=" "></textarea>
                        <label for="frommessagename"
                            class="pointer-events-none absolute left-4 top-0 z-10 origin-top-left -translate-y-0.5 scale-75 transform py-4 text-gray-medium duration-300 peer-placeholder-shown:translate-y-0.5 peer-placeholder-shown:scale-100 peer-focus:-translate-y-0.5 peer-focus:scale-75">Your
                            message</label>
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">
                        <input type="text" id="fromname" name="fromname" data-from-name
                            class="peer block w-full rounded border border-transparent bg-sand-light px-4 pb-2 pt-6 focus-within:border-white focus-within:outline-none"
                            placeholder=" " />
                        <label for="fromname"
                            class="pointer-events-none absolute left-4 top-0 z-10 origin-top-left -translate-y-0.5 scale-75 transform py-4 text-gray-medium duration-300 peer-placeholder-shown:translate-y-0.5 peer-placeholder-shown:scale-100 peer-focus:-translate-y-0.5 peer-focus:scale-75">From
                            name</label>
                    </div>

                </div>

                <button class="type-regular mt-16 rounded bg-yellow px-6 py-4 transition hover:bg-yellow-dark"
                    data-submit-gift-voucher>Add to basket
                    @svg('arrow-right', 'w-4 h-4 ml-12 inline-block')
                </button>

                <div class="type-regular mt-2 rounded bg-sand-light p-2" data-success-container style="display: none;">
                    Voucher added. <a class="underline" href="/basket/">Go to
                        basket</a></div>
                <div data-fail-container class="type-regular mt-4 max-w-2xl rounded bg-sand-light p-2"
                    style="display: none;">Something went wrong.</div>
            </div>
        </spektrix-gift-vouchers>

    </div>

@endsection
