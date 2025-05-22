@push('webComponents', '#spektrix-gift-vouchers')
@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page->id])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@section('content')
    <div class="fixed bg-black -z-10 inset-0 h-[75vh] lg:h-screen lg:w-1/2">

        @if ($page->mainImage)
            {{ $page->mainImage->img('square')->attributes(['class' => 'h-full w-full object-cover']) }}
        @endif
    </div>

    

    <div x-data="{ deliveryType: 'CustomerEmail' }" class="mt-[75vh] lg:mt-0 lg:ml-[50%] min-h-screen bg-sand relative">

        <div class="bg-sand-light pt-6 pb-12 lg:h-[66.6vh] flex flex-col">
            <div class="container">
                <a class="type-xs-mono relative z-50 border-transparent mb-4 inline-block uppercase border-2 pl-1 pr-4 py-2 rounded hover:border-sand"
                    href="{{ \App\Models\Page::getTemplateUrl('shop-page') }}">@svg('chevron-right', ' align-top h-4 w-4 inline-block transform rotate-180 origin-center')
                    Back </a>
            </div>
            <div class="container my-auto max-w-2xl ml-0">
                <h2 class="type-medium lg:type-large">{{ $page->name }}</h2>
                <p class="type-regular lg:type-medium !font-normal mt-6">{{ $page->subtitle }}</p>
            </div>
            <div class="type-regular pt-12 container !font-normal max-w-2xl ml-0">
                {{ $page->introduction }}
            </div>
        </div>


        <spektrix-gift-vouchers  client-name="{{ $settings['spektrix_client_name'] }}"
            custom-domain="{{ $settings['spektrix_custom_domain'] }}">

            <div class="container py-4 lg:pb-24">

                <div class="max-w-2xl border-b border-sand-dark py-8">
                    <div class="type-regular mb-4">
                        <span class="bg-yellow rounded-full p-2 h-10 w-10 inline-block text-center">1</span>
                        Choose amount
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">

                        <input type="number" id="amount" name="amount" data-amount 
                            class="peer block w-full bg-sand-light pl-7 pt-6 pb-2 px-4 rounded border border-transparent focus-within:border-white focus-within:outline-none"
                            placeholder=" "  />

                        <label for="amount"
                            class="scale-75 peer-focus:scale-75 peer-placeholder-shown:scale-100 pointer-events-none text-gray-medium absolute duration-300 transform py-4 top-0 z-10 left-4 origin-top-left peer-placeholder-shown:translate-y-0.5 -translate-y-0.5 peer-focus:-translate-y-0.5">Voucher
                            amount<sup>*</sup></label>

                        <span
                            class="absolute left-4 bottom-[0.55rem] peer-placeholder-shown:opacity-0 opacity-100 peer-focus:opacity-100">£</span>
                    </div>

                </div>

                <div class="max-w-2xl border-b border-sand-dark py-8">
                    <div class="type-regular mb-4">
                        <span class="bg-yellow rounded-full p-2 h-10 w-10 inline-block text-center">2</span>
                        Date to email voucher
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">
                        <input type="date" id="sendDate" name="sendDate" data-send-date
                            class="peer block w-full bg-sand-light pt-6 pb-2 px-4 rounded border border-transparent focus-within:border-white focus-within:outline-none"
                            placeholder=" " min="{{ date('Y-m-d') }}" />
                        <label for="sendDate"
                            class="scale-75 peer-focus:scale-75 peer-placeholder-shown:scale-100 pointer-events-none text-gray-medium absolute duration-300 transform py-4 top-0 z-10 left-4 origin-top-left peer-placeholder-shown:translate-y-0.5 -translate-y-0.5 peer-focus:-translate-y-0.5">Send
                            date</label>
                    </div>
                </div>

                <div class="max-w-2xl border-b border-sand-dark py-8">
                    <div class="type-regular mb-4">
                        <span class="bg-yellow rounded-full p-2 h-10 w-10 inline-block text-center">3</span>
                        Delivery email
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">

                        <label for="deliveryType"
                            class="scale-75 peer-focus:scale-75 peer-placeholder-shown:scale-100 pointer-events-none text-gray-medium absolute duration-300 transform py-4 top-0 z-10 left-4 origin-top-left peer-placeholder-shown:translate-y-0.5 -translate-y-0.5 peer-focus:-translate-y-0.5">Deliver
                            to</label>
                        <select
                            class="peer block w-full bg-sand-light pt-6 pb-2 px-3 rounded border border-transparent focus-within:border-white focus-within:outline-none"
                            @change="deliveryType = $event.target.value" name="deliveryType" data-delivery-type>
                            <option disabled selected value="">Select delivery type</option>
                            <option value="CustomerEmail">Your Email address</option>
                            <option value="OtherEmail">Another Email address</option>
                        </select>
                    </div>

                    <div x-show="deliveryType == 'OtherEmail'" class="relative z-0 mt-6 max-w-lg">

                        <input type="text" id="deliveryEmail" name="deliveryEmail" data-delivery-email-address
                            class="peer block w-full bg-sand-light pt-6 pb-2 px-4 rounded border border-transparent focus-within:border-white focus-within:outline-none"
                            placeholder=" " />

                        <label for="deliveryEmail"
                            class="scale-75 peer-focus:scale-75 peer-placeholder-shown:scale-100 pointer-events-none text-gray-medium absolute duration-300 transform py-4 top-0 z-10 left-4 origin-top-left peer-placeholder-shown:translate-y-0.5 -translate-y-0.5 peer-focus:-translate-y-0.5">Email
                            address to deliver to</label>

                    </div>

                </div>

                <div class="max-w-2xl border-b border-sand-dark py-8">
                    <div class="type-regular mb-4">
                        <span class="bg-yellow rounded-full p-2 h-10 w-10 inline-block text-center">4</span>
                        Add gift message
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">
                        <input type="text" id="toname" name="toname" data-to-name
                            class="peer block w-full bg-sand-light pt-6 pb-2 px-4 rounded border border-transparent focus-within:border-white focus-within:outline-none"
                            placeholder=" " />
                        <label for="toname"
                            class="scale-75 peer-focus:scale-75 peer-placeholder-shown:scale-100 pointer-events-none text-gray-medium absolute duration-300 transform py-4 top-0 z-10 left-4 origin-top-left peer-placeholder-shown:translate-y-0.5 -translate-y-0.5 peer-focus:-translate-y-0.5">Their
                            name</label>
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">
                        <textarea type="text" id="message" name="message" data-message
                            class="peer block w-full bg-sand-light pt-6 pb-2 px-4 rounded border border-transparent focus-within:border-white focus-within:outline-none"
                            placeholder=" "></textarea>
                        <label for="frommessagename"
                            class="scale-75 peer-focus:scale-75 peer-placeholder-shown:scale-100 pointer-events-none text-gray-medium absolute duration-300 transform py-4 top-0 z-10 left-4 origin-top-left peer-placeholder-shown:translate-y-0.5 -translate-y-0.5 peer-focus:-translate-y-0.5">Your
                            message</label>
                    </div>

                    <div class="relative z-0 mt-6 max-w-lg">
                        <input type="text" id="fromname" name="fromname" data-from-name
                            class="peer block w-full bg-sand-light pt-6 pb-2 px-4 rounded border border-transparent focus-within:border-white focus-within:outline-none"
                            placeholder=" " />
                        <label for="fromname"
                            class="scale-75 peer-focus:scale-75 peer-placeholder-shown:scale-100 pointer-events-none text-gray-medium absolute duration-300 transform py-4 top-0 z-10 left-4 origin-top-left peer-placeholder-shown:translate-y-0.5 -translate-y-0.5 peer-focus:-translate-y-0.5">From
                            name</label>
                    </div>

                </div>

                <button class="type-regular mt-16 py-4 px-6 rounded bg-yellow hover:bg-yellow-dark transition"
                    data-submit-gift-voucher>Add to basket
                    @svg('arrow-right', 'w-4 h-4 ml-12 inline-block')
                </button>

                <div class="type-regular mt-2 rounded p-2 bg-sand-light" data-success-container style="display: none;">
                    Voucher added. <a class="underline" href="/basket/">Go to
                        basket</a></div>
                <div data-fail-container class="type-regular max-w-2xl mt-4 bg-sand-light p-2 rounded"
                    style="display: none;">Something went wrong.</div>
            </div>
        </spektrix-gift-vouchers>

    </div>

@endsection
