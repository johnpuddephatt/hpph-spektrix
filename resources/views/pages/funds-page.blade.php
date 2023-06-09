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

            <div class="container my-12 grid md:grid-cols-2 gap-4">

                @foreach ($group->funds as $fundField)
                    @if ($fundField)
                        @php $fund = $fundField->fund @endphp
                        @if ($fund)
                            <div class="flex flex-col h-full">
                                @if ($fund->featuredImage)
                                    {!! $fund->featuredImage->img('landscape', ['class' => 'rounded mb-4'])->toHtml() !!}
                                @else
                                    <div class="aspect-video rounded bg-sand-dark mb-4"></div>
                                @endif
                                <div class="lg:grid-cols-3 grid gap-4">
                                    <h3 class="type-regular mb-4 max-w-xs">{{ $fund->name }}</h3>
                                    <div class="max-w-lg lg:col-span-2 mb-4">{{ $fund->description }}</div>
                                </div>
                                <spektrix-donate class="mt-auto block border-t border-sand-dark pt-4"
                                    client-name="{{ $settings['spektrix_client_name'] }}"
                                    custom-domain="{{ $settings['spektrix_custom_domain'] }}" fund-id="{{ $fund->id }}">

                                    <div class="gap-2 flex flex-col lg:flex-row mb-6 lg:mb-0 lg:mt-6">
                                        <div class="relative z-0">

                                            <input type="text" id="amount" name="amount" data-custom-donation-input
                                                class="peer block w-full bg-sand-light pl-7 pt-6 pb-2 px-4 rounded border border-transparent focus-within:border-white focus-within:outline-none"
                                                placeholder=" " value="20" />

                                            <label for="amount"
                                                class="scale-75 peer-focus:scale-75 peer-placeholder-shown:scale-100 pointer-events-none text-gray-medium absolute duration-300 transform py-4 top-0 z-10 left-4 origin-top-left peer-placeholder-shown:translate-y-0.5 -translate-y-0.5 peer-focus:-translate-y-0.5">Donation
                                                amount<sup>*</sup></label>

                                            <span
                                                class="absolute left-4 bottom-[0.55rem] peer-placeholder-shown:opacity-0 opacity-100 peer-focus:opacity-100">£</span>
                                        </div>

                                        <button class="type-regular flex-grow rounded bg-yellow py-3 pl-4 pr-3"
                                            data-submit-donation>Add
                                            to
                                            basket @svg('arrow-right', 'inline-block h-4 w-4 ml-auto')</button>

                                    </div>
                                    <div class="type-regular mt-2 rounded p-2 bg-sand-light" data-success-container
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
