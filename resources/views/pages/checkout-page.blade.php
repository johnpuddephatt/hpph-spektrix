@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page->id])])
@section('title', $page->name)
@section('content')
    <div class="fixed bg-black -z-10 inset-0 h-[75vh] lg:h-screen lg:w-1/2">

        @if ($page->mainImage)
            {{ $page->mainImage->img('square')->attributes(['class' => 'h-full w-full object-cover']) }}
        @endif
    </div>

    <div class="mt-[75vh] lg:mt-0 lg:ml-[50%] min-h-screen bg-sand relative">

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

        <div class="container pb-24 min-h-screen">
            <iframe
                src="https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/secure/checkout.aspx?resize=true"
                class="min-h-screen w-full" id="SpektrixIFrame" name="SpektrixIFrame"></iframe>
        </div>

    </div>

@endsection
