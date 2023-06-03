@push('webComponents', '#spektrix-merchandise')
@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'products', 'resourceId' => $product->id])])
@section('title', $product->name)
@section('content')
    <div class="fixed bg-black -z-10 inset-0 h-[75vh] lg:h-screen lg:w-1/2">
        @if ($product->featuredImage)
            {{ $product->featuredImage->img('square')->attributes(['class' => 'h-full w-full object-cover']) }}
        @endif
    </div>

    <div class="mt-[75vh] lg:mt-0 lg:ml-[50%] min-h-screen bg-sand relative">

        <div class="bg-sand-light pt-6 pb-12 lg:h-[66.6vh] flex flex-col">
            <div class="container">
                <div class="relative mr-auto float-left z-20">
                    <a class="type-xs-mono border-transparent mb-4 inline-block uppercase border-2 pl-1 pr-4 py-2 rounded hover:border-sand"
                        href="{{ \App\Models\Page::getTemplateUrl('shop-page') }}">@svg('chevron-right', ' align-top h-4 w-4 inline-block transform rotate-180 origin-center')
                        Back </a>
                </div>
            </div>
            <div class="container my-auto max-w-2xl ml-0">
                <h2 class="type-medium lg:type-large">{{ $product->name }}</h2>
                <p
                    class="type-regular lg:type-medium !font-/251/responsive-images/tote---adam-boardman___square_1338_1338.jpgnormal mt-6">
                    {{ $product->price }}</p>
            </div>
            <div class="type-regular pt-12 container !font-normal max-w-2xl ml-0">
                {{ $product->description }}
            </div>
        </div>

        @if ($product->content)
            <div class="container py-24">
                @foreach ($product->content as $layout)
                    @include('blocks.' . $layout->name(), ['layout' => $layout, 'dark' => false])
                @endforeach
            </div>
        @endif

        <spektrix-merchandise client-name="{{ $settings['spektrix_client_name'] }}"
            custom-domain="{{ $settings['spektrix_custom_domain'] }}" merchandise-item-id="{{ $product->id }}"
            merchandise-quantity="1">

            <div class="container pb-12 lg:pb-24">
                <div class="flex gap-4">
                    <div class="type-xs-mono !text-xl rounded bg-sand-light px-3 py-4">
                        <button data-decrement-quantity> - </button>
                        <span data-display-quantity></span>
                        <button data-increment-quantity> + </button>
                    </div>

                    <button class="type-regular py-4 px-6 rounded bg-yellow hover:bg-yellow-dark transition"
                        data-submit-merchandise>Add to basket
                        @svg('arrow-right', 'w-4 h-4 ml-12 inline-block')
                    </button>
                </div>
                <div data-success-container class="type-regular max-w-2xl mt-4 bg-sand-light p-2 rounded"
                    style="display: none;">Added to basket.</div>
                <div data-fail-container class="type-regular max-w-2xl mt-4 bg-sand-light p-2 rounded"
                    style="display: none;">Something went wrong.</div>
            </div>
        </spektrix-merchandise>

    </div>

@endsection
