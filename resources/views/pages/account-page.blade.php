@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page->id])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@section('content')
    <div class="fixed bg-black -z-10 inset-0 h-[50vh] xl:h-screen xl:w-1/2">

        @if ($page->mainImage)
            {{ $page->mainImage->img('square')->attributes(['class' => 'h-full w-full object-cover']) }}
        @endif
    </div>

    <div class="mt-[50vh] xl:mt-0 xl:ml-[50%] min-h-screen bg-sand relative">

        <div class="bg-sand-light pt-12 xl:pt-20 pb-8 xl:h-[50vh] flex flex-col">

            <div class="container my-auto max-w-2xl ml-0">
                <h2 class="type-medium xl:type-large">{{ $page->name }}</h2>
                <p class="type-regular xl:type-medium !font-normal xl:mt-6">{{ $page->subtitle }}</p>
            </div>

        </div>

        <div class="container pt-6 pb-24 min-h-screen">
            <iframe
                src="https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/secure/myaccount.aspx?Stylesheet=hpph-spektrix-2.css&resize=true{{ isset($_GET['screen']) ? '&Screen=' . $_GET['screen'] : '' }}"
                class="min-h-screen w-full xl:w-[calc(100%-2rem)]" id="SpektrixIFrame" name="SpektrixIFrame"></iframe>
        </div>

    </div>

@endsection
