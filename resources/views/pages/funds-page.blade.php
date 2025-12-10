@extends('layouts.default', ['header_class' => 'text-white lg:text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@push('webComponents', '#spektrix-donate')

@section('content')
    @include('sections.pageheader_alternative')
    <div class="bg-sand pb-16">
        @foreach ($page->content as $group)
            <div class="mb-8 bg-yellow">
                <h2 class="type-regular container py-8">
                    {{ $group->fund_group_title }}
                </h2>
            </div>

            <div class="container my-12 grid gap-4 md:grid-cols-2">

                @foreach ($group->funds as $fundField)
                    @if ($fundField)
                        @php $fund = $fundField->fund @endphp
                        @if ($fund)
                            <div class="flex h-full flex-col">
                                @if ($fund->featuredImage)
                                    {!! $fund->featuredImage->img('landscape', ['class' => 'rounded mb-4'])->toHtml() !!}
                                @else
                                    <div class="mb-4 aspect-video rounded bg-sand-dark"></div>
                                @endif
                                <div class="grid gap-4 lg:grid-cols-3">
                                    <h3 class="type-regular mb-4 max-w-xs">{{ $fund->name }}</h3>
                                    <div class="mb-4 max-w-lg lg:col-span-2">{{ $fund->description }}</div>
                                </div>
                                <spektrix-donate x-data="{ amount: {{ $fund->default_donation_amount }} }" class="mt-auto block border-t border-sand-dark pt-4"
                                    x-effect="$el.donationAmount = amount" x-init="$el.donationAmount = amount;
                                    setTimeout(() => { $el.donationAmount = amount }, 3000)"
                                    client-name="{{ $settings['spektrix_client_name'] }}"
                                    custom-domain="{{ $settings['spektrix_custom_domain'] }}" fund-id="{{ $fund->id }}">

                                    <div class="mb-6 flex flex-col gap-2 lg:mb-0 lg:mt-6 lg:flex-row">
                                        <div class="relative z-0">

                                            <input type="number" id="amount" name="amount" x-model="amount"
                                                class="peer block w-full rounded border border-transparent bg-sand-light px-4 pb-2 pl-7 pt-6 focus-within:border-white focus-within:outline-none"
                                                placeholder=" " min="{{ $fund->default_donation_amount }}" />

                                            <label for="amount"
                                                class="pointer-events-none absolute left-4 top-0 z-10 origin-top-left -translate-y-0.5 scale-75 transform py-4 text-gray-medium duration-300 peer-placeholder-shown:translate-y-0.5 peer-placeholder-shown:scale-100 peer-focus:-translate-y-0.5 peer-focus:scale-75">Donation
                                                amount<sup>*</sup></label>

                                            <span
                                                class="absolute bottom-[0.55rem] left-4 opacity-100 peer-placeholder-shown:opacity-0 peer-focus:opacity-100">£</span>
                                        </div>

                                        <button class="type-regular flex-grow rounded bg-yellow py-3 pl-4 pr-3"
                                            data-submit-donation>Add
                                            to
                                            basket @svg('arrow-right', 'inline-block h-4 w-4 ml-auto')</button>

                                    </div>
                                    <div class="type-regular mt-2 rounded bg-sand-light p-2" data-success-container
                                        style="display: none;">Donation added. <a class="underline" href="/basket/">Go to
                                            basket</a></div>
                                    <div data-fail-container style="display: none;">Donation could not be added to basket
                                    </div>
                                </spektrix-donate>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
