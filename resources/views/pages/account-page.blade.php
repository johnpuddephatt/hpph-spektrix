@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page->id])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)

@section('content')
    <div class="fixed bg-black -z-10 inset-0 h-[50vh] md:h-screen md:w-1/2">

        @if ($page->mainImage)
            {{ $page->mainImage->img('square')->attributes(['class' => 'h-full w-full object-cover']) }}
        @endif
    </div>

    <div class="mt-[50vh] md:mt-0 md:ml-[50%] min-h-screen bg-sand relative">

        <div class="bg-sand-light pt-12 md:pt-20 pb-8 md:h-[50vh] flex flex-col">

            <div class="container my-auto max-w-2xl ml-0">
                <h2 class="type-medium md:type-large">{{ $page->name }}</h2>
                <p class="type-regular md:type-medium !font-normal md:mt-6">{{ $page->subtitle }}</p>
            </div>

        </div>

        <div class="container pt-6 pb-24 min-h-screen">
            <iframe
                src="https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/secure/myaccount.aspx?resize=true"
                class="min-h-screen w-full md:w-[calc(100%-2rem)]" id="SpektrixIFrame" name="SpektrixIFrame"></iframe>
        </div>

    </div>

@endsection
