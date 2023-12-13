@php
if (isset($_GET['selected'])) {
    $selectedMembershipId = $_GET['selected'];
    $selectedMembership = \App\Models\Membership::find($selectedMembershipId);
    if ($selectedMembership) {
        $page->name = "Gift $selectedMembership->name";
        $page->subtitle = $selectedMembership->price;
    }
}
@endphp
@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page->id])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@section('content')
    <div class="fixed bg-black -z-10 inset-0 h-[75vh] lg:h-screen lg:w-1/2">
        @if ($selectedMembership->image)
            <img src="{{ Storage::url($selectedMembership->image) }}" class="h-full w-full object-contain object-center">
            <img src="{{ Storage::url($selectedMembership->logo) }}"
                class="w-40 h-auto absolute -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" />
        @elseif ($page->mainImage)
            {{ $page->mainImage->img('square')->attributes(['class' => 'h-full w-full object-cover']) }}
        @endif
    </div>

    <div class="mt-[75vh] lg:mt-0 lg:ml-[50%] min-h-screen bg-sand relative">

        <div class="bg-sand-light pt-6 pb-12 lg:h-[66.6vh] flex flex-col">
            <div class="container">
                <a class="type-xs-mono relative z-50 border-transparent mb-4 inline-block uppercase border-2 pl-1 pr-4 py-2 rounded hover:border-sand"
                    href="{{ \App\Models\Page::getTemplateUrl('memberships-page') }}">@svg('chevron-right', ' align-top h-4 w-4 inline-block transform rotate-180 origin-center')
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

        <div class="container pt-6 pb-24 min-h-screen">
            @if (isset($selectedMembership))
                <iframe
                    src="https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/GiftVouchers.aspx?resize=true&MembershipId={{ filter_var($_GET['selected'], FILTER_SANITIZE_NUMBER_INT) }}"
                    class="min-h-screen w-full xl:w-[calc(100%-2rem)]" id="SpektrixIFrame" name="SpektrixIFrame"></iframe>
            @else
                <h3 class="type-medium mb-6">Choose a membership</h3>
                @foreach (\App\Models\Membership::where('price', '!=', 0)->get() as $membership)
                    <a href="?selected={{ $membership->id }}" class="block bg-sand-light rounded p-4 mb-4">
                        <h3 class="type-regular">{{ $membership->name }}</h3>
                        <p class="type-regular !font-normal">{{ $membership->price }}</p>
                    </a>
                @endforeach
            @endif
        </div>

    </div>

@endsection
