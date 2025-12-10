{{-- @php
    if (isset($_GET['selected'])) {
        $selectedMembershipId = $_GET['selected'];
        $selectedMembership = \App\Models\Membership::find($selectedMembershipId);
        if ($selectedMembership) {
            $page->name = "Gift $selectedMembership->name";
            $page->subtitle = $selectedMembership->price;
        }
    }
@endphp --}}
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

    <div class="relative mt-[75vh] min-h-screen bg-sand lg:ml-[50%] lg:mt-0">

        <div class="flex flex-col bg-sand-light pb-12 pt-6 lg:h-[66.6vh]">
            <div class="container">
                {{-- <a class="type-xs-mono relative z-50 mb-4 inline-block rounded border-2 border-transparent py-2 pl-1 pr-4 uppercase hover:border-sand"
                    href="{{ \App\Models\Page::getTemplateUrl('memberships-page') }}">@svg('chevron-right', ' align-top h-4 w-4 inline-block transform rotate-180 origin-center')
                    Back </a> --}}
            </div>
            <div class="container my-auto ml-0 max-w-2xl">
                <h2 class="type-medium lg:type-large">{{ $page->name }}</h2>
                <p class="type-regular lg:type-medium mt-6 !font-normal">{{ $page->subtitle }}</p>
            </div>
            <div class="type-regular container ml-0 max-w-2xl pt-12 !font-normal">
                {{ $page->introduction }}
            </div>
        </div>

        <div class="container min-h-screen pb-24 pt-6">

            <iframe
                src="https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/TicketSubscriptions?Stylesheet=hpph-spektrix-2.css&resize=true"
                class="min-h-screen w-full xl:w-[calc(100%-2rem)]" id="SpektrixIFrame" name="SpektrixIFrame"></iframe>

        </div>

    </div>

@endsection
